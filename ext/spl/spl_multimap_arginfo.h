/* This is a generated file, edit the .stub.php file instead.
 * Stub hash: 54a96c54cbb58d59c94478d675269f30b0ae5178 */

ZEND_BEGIN_ARG_INFO_EX(arginfo_class_SplMultiMap___construct, 0, 0, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_class_SplMultiMap_put, 0, 2, IS_VOID, 0)
	ZEND_ARG_TYPE_INFO(0, key, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, value, IS_MIXED, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_class_SplMultiMap_putAll, 0, 2, IS_VOID, 0)
	ZEND_ARG_TYPE_INFO(0, key, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, values, IS_ARRAY, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_class_SplMultiMap_get, 0, 1, IS_ARRAY, 0)
	ZEND_ARG_TYPE_INFO(0, key, IS_STRING, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_class_SplMultiMap_remove, 0, 2, _IS_BOOL, 0)
	ZEND_ARG_TYPE_INFO(0, key, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, value, IS_MIXED, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_class_SplMultiMap_removeAll, 0, 1, _IS_BOOL, 0)
	ZEND_ARG_TYPE_INFO(0, key, IS_STRING, 0)
ZEND_END_ARG_INFO()

#define arginfo_class_SplMultiMap_replaceAll arginfo_class_SplMultiMap_putAll

#define arginfo_class_SplMultiMap_containsKey arginfo_class_SplMultiMap_removeAll

#define arginfo_class_SplMultiMap_containsValue arginfo_class_SplMultiMap_remove

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_class_SplMultiMap_keys, 0, 0, IS_ARRAY, 0)
ZEND_END_ARG_INFO()

#define arginfo_class_SplMultiMap_values arginfo_class_SplMultiMap_keys

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_class_SplMultiMap_isEmpty, 0, 0, _IS_BOOL, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_class_SplMultiMap_clear, 0, 0, IS_VOID, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_class_SplMultiMap_count, 0, 0, IS_LONG, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_OBJ_INFO_EX(arginfo_class_SplMultiMap_getIterator, 0, 0, Iterator, 0)
ZEND_END_ARG_INFO()

ZEND_METHOD(SplMultiMap, __construct);
ZEND_METHOD(SplMultiMap, put);
ZEND_METHOD(SplMultiMap, putAll);
ZEND_METHOD(SplMultiMap, get);
ZEND_METHOD(SplMultiMap, remove);
ZEND_METHOD(SplMultiMap, removeAll);
ZEND_METHOD(SplMultiMap, replaceAll);
ZEND_METHOD(SplMultiMap, containsKey);
ZEND_METHOD(SplMultiMap, containsValue);
ZEND_METHOD(SplMultiMap, keys);
ZEND_METHOD(SplMultiMap, values);
ZEND_METHOD(SplMultiMap, isEmpty);
ZEND_METHOD(SplMultiMap, clear);
ZEND_METHOD(SplMultiMap, count);
ZEND_METHOD(SplMultiMap, getIterator);

static const zend_function_entry class_SplMultiMap_methods[] = {
	ZEND_ME(SplMultiMap, __construct, arginfo_class_SplMultiMap___construct, ZEND_ACC_PUBLIC)
	ZEND_ME(SplMultiMap, put, arginfo_class_SplMultiMap_put, ZEND_ACC_PUBLIC)
	ZEND_ME(SplMultiMap, putAll, arginfo_class_SplMultiMap_putAll, ZEND_ACC_PUBLIC)
	ZEND_ME(SplMultiMap, get, arginfo_class_SplMultiMap_get, ZEND_ACC_PUBLIC)
	ZEND_ME(SplMultiMap, remove, arginfo_class_SplMultiMap_remove, ZEND_ACC_PUBLIC)
	ZEND_ME(SplMultiMap, removeAll, arginfo_class_SplMultiMap_removeAll, ZEND_ACC_PUBLIC)
	ZEND_ME(SplMultiMap, replaceAll, arginfo_class_SplMultiMap_replaceAll, ZEND_ACC_PUBLIC)
	ZEND_ME(SplMultiMap, containsKey, arginfo_class_SplMultiMap_containsKey, ZEND_ACC_PUBLIC)
	ZEND_ME(SplMultiMap, containsValue, arginfo_class_SplMultiMap_containsValue, ZEND_ACC_PUBLIC)
	ZEND_ME(SplMultiMap, keys, arginfo_class_SplMultiMap_keys, ZEND_ACC_PUBLIC)
	ZEND_ME(SplMultiMap, values, arginfo_class_SplMultiMap_values, ZEND_ACC_PUBLIC)
	ZEND_ME(SplMultiMap, isEmpty, arginfo_class_SplMultiMap_isEmpty, ZEND_ACC_PUBLIC)
	ZEND_ME(SplMultiMap, clear, arginfo_class_SplMultiMap_clear, ZEND_ACC_PUBLIC)
	ZEND_ME(SplMultiMap, count, arginfo_class_SplMultiMap_count, ZEND_ACC_PUBLIC)
	ZEND_ME(SplMultiMap, getIterator, arginfo_class_SplMultiMap_getIterator, ZEND_ACC_PUBLIC)
	ZEND_FE_END
};

static zend_class_entry *register_class_SplMultiMap(zend_class_entry *class_entry_IteratorAggregate, zend_class_entry *class_entry_Countable)
{
	zend_class_entry ce, *class_entry;

	INIT_CLASS_ENTRY(ce, "SplMultiMap", class_SplMultiMap_methods);
	class_entry = zend_register_internal_class_with_flags(&ce, NULL, 0);
	zend_class_implements(class_entry, 2, class_entry_IteratorAggregate, class_entry_Countable);

	return class_entry;
}
