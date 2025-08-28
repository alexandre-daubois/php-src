/*
  +----------------------------------------------------------------------+
  | Copyright (c) The PHP Group                                          |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | https://www.php.net/license/3_01.txt                                 |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
*/

#ifdef HAVE_CONFIG_H
#include <config.h>
#endif

#include "php.h"
#include "zend_interfaces.h"
#include "zend_exceptions.h"

#include "spl_multimap_arginfo.h"
#include "spl_multimap.h"
#include "spl_exceptions.h"

static zend_object_handlers spl_handler_SplMultiMap;
PHPAPI zend_class_entry *spl_ce_SplMultiMap;

typedef struct _spl_multimap {
	HashTable *data;
	zend_long total_size;
} spl_multimap;

typedef struct _spl_multimap_object {
	spl_multimap multimap;
	zend_object std;
} spl_multimap_object;

typedef struct _spl_multimap_it {
	zend_object_iterator intern;
	zend_string *current_key;
	zend_long current_value_index;
} spl_multimap_it;

static spl_multimap_object *spl_multimap_from_obj(zend_object *obj)
{
	return (spl_multimap_object*)((char*)(obj) - XtOffsetOf(spl_multimap_object, std));
}

#define Z_SPLMULTIMAP_P(zv) spl_multimap_from_obj(Z_OBJ_P((zv)))

static void spl_multimap_init(spl_multimap *multimap)
{
	ALLOC_HASHTABLE(multimap->data);
	zend_hash_init(multimap->data, 0, NULL, ZVAL_PTR_DTOR, 0);
	multimap->total_size = 0;
}

static void spl_multimap_destroy(spl_multimap *multimap)
{
	if (multimap->data) {
		zend_hash_destroy(multimap->data);
		FREE_HASHTABLE(multimap->data);
		multimap->data = NULL;
	}

	multimap->total_size = 0;
}

static zend_object *spl_multimap_new(zend_class_entry *class_type)
{
	spl_multimap_object *intern;

	intern = zend_object_alloc(sizeof(spl_multimap_object), class_type);

	zend_object_std_init(&intern->std, class_type);
	object_properties_init(&intern->std, class_type);

	spl_multimap_init(&intern->multimap);

	intern->std.handlers = &spl_handler_SplMultiMap;

	return &intern->std;
}

static void spl_multimap_object_free_storage(zend_object *object)
{
	spl_multimap_object *intern = spl_multimap_from_obj(object);

	spl_multimap_destroy(&intern->multimap);

	zend_object_std_dtor(&intern->std);
}

static HashTable *spl_multimap_object_get_gc(zend_object *obj, zval **table, int *n)
{
	spl_multimap_object *intern = spl_multimap_from_obj(obj);

	*table = NULL;
	*n = 0;

	return intern->multimap.data;
}

static zend_object *spl_multimap_object_clone(zend_object *obj)
{
	spl_multimap_object *old_object = spl_multimap_from_obj(obj);
	zend_object *new_obj = spl_multimap_new(obj->ce);
	spl_multimap_object *new_object = spl_multimap_from_obj(new_obj);

	zend_objects_clone_members(new_obj, obj);

	spl_multimap_destroy(&new_object->multimap);
	spl_multimap_init(&new_object->multimap);

	new_object->multimap.total_size = old_object->multimap.total_size;

	zend_string *key;
	zval *key_array;
	ZEND_HASH_MAP_FOREACH_STR_KEY_VAL(old_object->multimap.data, key, key_array) {
		zval new_array;
		array_init(&new_array);

		zval *current_value;
		ZEND_HASH_FOREACH_VAL(Z_ARRVAL_P(key_array), current_value) {
			Z_TRY_ADDREF_P(current_value);
			add_next_index_zval(&new_array, current_value);
		} ZEND_HASH_FOREACH_END();

		zend_hash_update(new_object->multimap.data, key, &new_array);
	} ZEND_HASH_FOREACH_END();

	return new_obj;
}

static zend_result spl_multimap_object_count_elements(zend_object *object, zend_long *count)
{
	spl_multimap_object *intern = spl_multimap_from_obj(object);
	*count = intern->multimap.total_size;

	return SUCCESS;
}

PHP_METHOD(SplMultiMap, __construct)
{
	ZEND_PARSE_PARAMETERS_NONE();
}

PHP_METHOD(SplMultiMap, put)
{
	zend_string *key;
	zval *value;
	spl_multimap_object *intern;
	zval *key_array;

	ZEND_PARSE_PARAMETERS_START(2, 2)
		Z_PARAM_STR(key)
		Z_PARAM_ZVAL(value)
	ZEND_PARSE_PARAMETERS_END();

	intern = Z_SPLMULTIMAP_P(ZEND_THIS);
	key_array = zend_hash_find(intern->multimap.data, key);

	if (key_array == NULL) {
		zval new_array;

		array_init(&new_array);
		key_array = zend_hash_add(intern->multimap.data, key, &new_array);
	}

	Z_TRY_ADDREF_P(value);
	add_next_index_zval(key_array, value);

	intern->multimap.total_size++;
}

PHP_METHOD(SplMultiMap, putAll)
{
	zend_string *key;
	zval *values;
	spl_multimap_object *intern;
	zval *key_array;

	ZEND_PARSE_PARAMETERS_START(2, 2)
		Z_PARAM_STR(key)
		Z_PARAM_ARRAY(values)
	ZEND_PARSE_PARAMETERS_END();

	intern = Z_SPLMULTIMAP_P(ZEND_THIS);

	// Only create the key if we have values to add
	if (zend_array_count(Z_ARRVAL_P(values)) == 0) {
		return;
	}

	key_array = zend_hash_find(intern->multimap.data, key);
	if (key_array == NULL) {
		zval new_array;
		array_init(&new_array);
		key_array = zend_hash_add(intern->multimap.data, key, &new_array);
	}

	zval *current_value;
	ZEND_HASH_FOREACH_VAL(Z_ARRVAL_P(values), current_value) {
		Z_TRY_ADDREF_P(current_value);
		add_next_index_zval(key_array, current_value);
		intern->multimap.total_size++;
	} ZEND_HASH_FOREACH_END();
}

PHP_METHOD(SplMultiMap, get)
{
	zend_string *key;
	spl_multimap_object *intern;
	zval *key_array;

	ZEND_PARSE_PARAMETERS_START(1, 1)
		Z_PARAM_STR(key)
	ZEND_PARSE_PARAMETERS_END();

	intern = Z_SPLMULTIMAP_P(ZEND_THIS);

	key_array = zend_hash_find(intern->multimap.data, key);
	if (key_array == NULL) {
		array_init(return_value);
		return;
	}

	ZVAL_COPY(return_value, key_array);
}

PHP_METHOD(SplMultiMap, remove)
{
	zend_string *key;
	zval *value;
	spl_multimap_object *intern;
	zval *key_array;

	ZEND_PARSE_PARAMETERS_START(2, 2)
		Z_PARAM_STR(key)
		Z_PARAM_ZVAL(value)
	ZEND_PARSE_PARAMETERS_END();

	intern = Z_SPLMULTIMAP_P(ZEND_THIS);

	key_array = zend_hash_find(intern->multimap.data, key);
	if (key_array == NULL) {
		RETURN_FALSE;
	}

	HashTable *ht = Z_ARRVAL_P(key_array);
	bool found = false;
	zval new_array;
	array_init(&new_array);

	zval *current_value;
	ZEND_HASH_FOREACH_VAL(ht, current_value) {
        if (!found && zend_is_identical(value, current_value)) {
            found = true;
        } else {
            Z_TRY_ADDREF_P(current_value);
            add_next_index_zval(&new_array, current_value);
        }
	} ZEND_HASH_FOREACH_END();
	
	if (found) {
		zend_hash_update(intern->multimap.data, key, &new_array);
		intern->multimap.total_size--;

		if (zend_array_count(Z_ARRVAL_P(zend_hash_find(intern->multimap.data, key))) == 0) {
			zend_hash_del(intern->multimap.data, key);
		}
	} else {
        zval_ptr_dtor(&new_array);
	}

	RETURN_BOOL(found);
}

PHP_METHOD(SplMultiMap, removeAll)
{
	zend_string *key;
	spl_multimap_object *intern;
	zval *key_array;

	ZEND_PARSE_PARAMETERS_START(1, 1)
		Z_PARAM_STR(key)
	ZEND_PARSE_PARAMETERS_END();

	intern = Z_SPLMULTIMAP_P(ZEND_THIS);

	key_array = zend_hash_find(intern->multimap.data, key);
	if (key_array == NULL) {
		RETURN_FALSE;
	}

	intern->multimap.total_size -= zend_array_count(Z_ARRVAL_P(key_array));
	zend_hash_del(intern->multimap.data, key);
	RETURN_TRUE;
}

PHP_METHOD(SplMultiMap, replaceAll)
{
	zend_string *key;
	zval *values;
	spl_multimap_object *intern;
	zval *key_array;

	ZEND_PARSE_PARAMETERS_START(2, 2)
		Z_PARAM_STR(key)
		Z_PARAM_ARRAY(values)
	ZEND_PARSE_PARAMETERS_END();

	intern = Z_SPLMULTIMAP_P(ZEND_THIS);

	/* Remove existing values for this key if they exist. */
	key_array = zend_hash_find(intern->multimap.data, key);
	if (key_array != NULL) {
		intern->multimap.total_size -= zend_array_count(Z_ARRVAL_P(key_array));
	}

	zval new_array;
	array_init(&new_array);
	key_array = zend_hash_update(intern->multimap.data, key, &new_array);

	zval *current_value;
	ZEND_HASH_FOREACH_VAL(Z_ARRVAL_P(values), current_value) {
		Z_TRY_ADDREF_P(current_value);
		add_next_index_zval(key_array, current_value);
		intern->multimap.total_size++;
	} ZEND_HASH_FOREACH_END();

	if (zend_array_count(Z_ARRVAL_P(key_array)) == 0) {
		zend_hash_del(intern->multimap.data, key);
	}
}

PHP_METHOD(SplMultiMap, containsKey)
{
	zend_string *key;
	spl_multimap_object *intern;

	ZEND_PARSE_PARAMETERS_START(1, 1)
		Z_PARAM_STR(key)
	ZEND_PARSE_PARAMETERS_END();

	intern = Z_SPLMULTIMAP_P(ZEND_THIS);

	RETURN_BOOL(zend_hash_exists(intern->multimap.data, key));
}

PHP_METHOD(SplMultiMap, containsValue)
{
	zend_string *key;
	zval *value;
	spl_multimap_object *intern;
	zval *key_array;

	ZEND_PARSE_PARAMETERS_START(2, 2)
		Z_PARAM_STR(key)
		Z_PARAM_ZVAL(value)
	ZEND_PARSE_PARAMETERS_END();

	intern = Z_SPLMULTIMAP_P(ZEND_THIS);

	key_array = zend_hash_find(intern->multimap.data, key);
	if (key_array == NULL) {
		RETURN_FALSE;
	}

	zval *current_value;
	ZEND_HASH_FOREACH_VAL(Z_ARRVAL_P(key_array), current_value) {
		if (zend_is_identical(value, current_value)) {
			RETURN_TRUE;
		}
	} ZEND_HASH_FOREACH_END();

	RETURN_FALSE;
}

PHP_METHOD(SplMultiMap, keys)
{
	spl_multimap_object *intern;
	zend_string *key;

	ZEND_PARSE_PARAMETERS_NONE();

	intern = Z_SPLMULTIMAP_P(ZEND_THIS);

	array_init(return_value);

	ZEND_HASH_MAP_FOREACH_STR_KEY(intern->multimap.data, key) {
		add_next_index_str(return_value, zend_string_copy(key));
	} ZEND_HASH_FOREACH_END();
}

PHP_METHOD(SplMultiMap, values)
{
	spl_multimap_object *intern;
	zval *key_array, *current_value;

	ZEND_PARSE_PARAMETERS_NONE();

	intern = Z_SPLMULTIMAP_P(ZEND_THIS);
	array_init(return_value);

	ZEND_HASH_FOREACH_VAL(intern->multimap.data, key_array) {
		ZEND_HASH_FOREACH_VAL(Z_ARRVAL_P(key_array), current_value) {
			Z_TRY_ADDREF_P(current_value);
			add_next_index_zval(return_value, current_value);
		} ZEND_HASH_FOREACH_END();
	} ZEND_HASH_FOREACH_END();
}


PHP_METHOD(SplMultiMap, isEmpty)
{
	spl_multimap_object *intern;

	ZEND_PARSE_PARAMETERS_NONE();

	intern = Z_SPLMULTIMAP_P(ZEND_THIS);

	RETURN_BOOL(intern->multimap.total_size == 0);
}

PHP_METHOD(SplMultiMap, clear)
{
	spl_multimap_object *intern;

	ZEND_PARSE_PARAMETERS_NONE();

	intern = Z_SPLMULTIMAP_P(ZEND_THIS);

	zend_hash_clean(intern->multimap.data);
	intern->multimap.total_size = 0;
}

PHP_METHOD(SplMultiMap, count)
{
	spl_multimap_object *intern;

	ZEND_PARSE_PARAMETERS_NONE();

	intern = Z_SPLMULTIMAP_P(ZEND_THIS);

	RETURN_LONG(intern->multimap.total_size);
}

static void spl_multimap_it_dtor(zend_object_iterator *iter)
{
	spl_multimap_it *iterator = (spl_multimap_it*)iter;
	
	if (iterator->current_key) {
		zend_string_release(iterator->current_key);
	}

	zval_ptr_dtor(&iter->data);
}

static void spl_multimap_it_rewind(zend_object_iterator *iter)
{
	spl_multimap_it *iterator = (spl_multimap_it*)iter;
	spl_multimap_object *object = Z_SPLMULTIMAP_P(&iter->data);

	iterator->current_value_index = 0;

	if (iterator->current_key) {
		zend_string_release(iterator->current_key);
		iterator->current_key = NULL;
	}

	zend_string *key;
	zend_hash_internal_pointer_reset(object->multimap.data);
	if (zend_hash_get_current_key(object->multimap.data, &key, NULL) == HASH_KEY_IS_STRING) {
		iterator->current_key = zend_string_copy(key);
	}
}

static zend_result spl_multimap_it_valid(zend_object_iterator *iter)
{
	spl_multimap_it *iterator = (spl_multimap_it*)iter;
	spl_multimap_object *object = Z_SPLMULTIMAP_P(&iter->data);

	if (!iterator->current_key) {
		return FAILURE;
	}

	zval *key_array = zend_hash_find(object->multimap.data, iterator->current_key);
	if (!key_array) {
		return FAILURE;
	}

	return iterator->current_value_index < zend_array_count(Z_ARRVAL_P(key_array)) ? SUCCESS : FAILURE;
}

static zval *spl_multimap_it_get_current_data(zend_object_iterator *iter)
{
	spl_multimap_it *iterator = (spl_multimap_it*)iter;
	spl_multimap_object *object = Z_SPLMULTIMAP_P(&iter->data);

	if (!iterator->current_key) {
		return &EG(uninitialized_zval);
	}

	zval *key_array = zend_hash_find(object->multimap.data, iterator->current_key);
	if (!key_array) {
		return &EG(uninitialized_zval);
	}

	zval *value = zend_hash_index_find(Z_ARRVAL_P(key_array), iterator->current_value_index);

	return value ? value : &EG(uninitialized_zval);
}

static void spl_multimap_it_get_current_key(zend_object_iterator *iter, zval *key)
{
	spl_multimap_it *iterator = (spl_multimap_it*)iter;

	if (iterator->current_key) {
		ZVAL_STR_COPY(key, iterator->current_key);
	} else {
		ZVAL_NULL(key);
	}
}

static void spl_multimap_it_move_forward(zend_object_iterator *iter)
{
	spl_multimap_it *iterator = (spl_multimap_it*)iter;
	spl_multimap_object *object = Z_SPLMULTIMAP_P(&iter->data);

	if (!iterator->current_key) {
		return;
	}

	zval *key_array = zend_hash_find(object->multimap.data, iterator->current_key);
	if (!key_array) {
		return;
	}

	iterator->current_value_index++;

	if (iterator->current_value_index >= zend_array_count(Z_ARRVAL_P(key_array))) {
		zend_hash_move_forward(object->multimap.data);
		iterator->current_value_index = 0;

		if (iterator->current_key) {
			zend_string_release(iterator->current_key);
			iterator->current_key = NULL;
		}

		zend_string *key;
		if (zend_hash_get_current_key(object->multimap.data, &key, NULL) == HASH_KEY_IS_STRING) {
			iterator->current_key = zend_string_copy(key);
		}
	}
}

static const zend_object_iterator_funcs spl_multimap_it_funcs = {
	spl_multimap_it_dtor,
	spl_multimap_it_valid,
	spl_multimap_it_get_current_data,
	spl_multimap_it_get_current_key,
	spl_multimap_it_move_forward,
	spl_multimap_it_rewind,
	NULL,
	NULL,
};

static zend_object_iterator *spl_multimap_get_iterator(zend_class_entry *ce, zval *object, int by_ref)
{
	spl_multimap_it *iterator;

	if (by_ref) {
		zend_throw_error(NULL, "An iterator cannot be used with foreach by reference");
		return NULL;
	}

	iterator = emalloc(sizeof(spl_multimap_it));

	zend_iterator_init((zend_object_iterator*)iterator);

	ZVAL_OBJ_COPY(&iterator->intern.data, Z_OBJ_P(object));
	iterator->intern.funcs = &spl_multimap_it_funcs;
	iterator->current_key = NULL;
	iterator->current_value_index = 0;

	return &iterator->intern;
}

PHP_METHOD(SplMultiMap, getIterator)
{
	ZEND_PARSE_PARAMETERS_NONE();

	zend_create_internal_iterator_zval(return_value, ZEND_THIS);
}

PHP_MINIT_FUNCTION(spl_multimap)
{
	spl_ce_SplMultiMap = register_class_SplMultiMap(zend_ce_aggregate, zend_ce_countable);

	spl_ce_SplMultiMap->create_object = spl_multimap_new;
	spl_ce_SplMultiMap->default_object_handlers = &spl_handler_SplMultiMap;
	spl_ce_SplMultiMap->get_iterator = spl_multimap_get_iterator;

	memcpy(&spl_handler_SplMultiMap, &std_object_handlers, sizeof(zend_object_handlers));

	spl_handler_SplMultiMap.offset = XtOffsetOf(spl_multimap_object, std);
	spl_handler_SplMultiMap.count_elements = spl_multimap_object_count_elements;
	spl_handler_SplMultiMap.get_gc = spl_multimap_object_get_gc;
	spl_handler_SplMultiMap.free_obj = spl_multimap_object_free_storage;
	spl_handler_SplMultiMap.clone_obj = spl_multimap_object_clone;

	return SUCCESS;
}
