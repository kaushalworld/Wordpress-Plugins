<?php

# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/protobuf/descriptor.proto
namespace Google\Protobuf\Internal;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\GPBWire;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\InputStream;
use Google\Protobuf\Internal\GPBUtil;
/**
 * Generated from protobuf message <code>google.protobuf.FileOptions</code>
 */
class FileOptions extends \Google\Protobuf\Internal\Message
{
    /**
     * Sets the Java package where classes generated from this .proto will be
     * placed.  By default, the proto package is used, but this is often
     * inappropriate because proto packages do not normally start with backwards
     * domain names.
     *
     * Generated from protobuf field <code>optional string java_package = 1;</code>
     */
    protected $java_package = null;
    /**
     * Controls the name of the wrapper Java class generated for the .proto file.
     * That class will always contain the .proto file's getDescriptor() method as
     * well as any top-level extensions defined in the .proto file.
     * If java_multiple_files is disabled, then all the other classes from the
     * .proto file will be nested inside the single wrapper outer class.
     *
     * Generated from protobuf field <code>optional string java_outer_classname = 8;</code>
     */
    protected $java_outer_classname = null;
    /**
     * If enabled, then the Java code generator will generate a separate .java
     * file for each top-level message, enum, and service defined in the .proto
     * file.  Thus, these types will *not* be nested inside the wrapper class
     * named by java_outer_classname.  However, the wrapper class will still be
     * generated to contain the file's getDescriptor() method as well as any
     * top-level extensions defined in the file.
     *
     * Generated from protobuf field <code>optional bool java_multiple_files = 10 [default = false];</code>
     */
    protected $java_multiple_files = null;
    /**
     * This option does nothing.
     *
     * Generated from protobuf field <code>optional bool java_generate_equals_and_hash = 20 [deprecated = true];</code>
     * @deprecated
     */
    protected $java_generate_equals_and_hash = null;
    /**
     * If set true, then the Java2 code generator will generate code that
     * throws an exception whenever an attempt is made to assign a non-UTF-8
     * byte sequence to a string field.
     * Message reflection will do the same.
     * However, an extension field still accepts non-UTF-8 byte sequences.
     * This option has no effect on when used with the lite runtime.
     *
     * Generated from protobuf field <code>optional bool java_string_check_utf8 = 27 [default = false];</code>
     */
    protected $java_string_check_utf8 = null;
    /**
     * Generated from protobuf field <code>optional .google.protobuf.FileOptions.OptimizeMode optimize_for = 9 [default = SPEED];</code>
     */
    protected $optimize_for = null;
    /**
     * Sets the Go package where structs generated from this .proto will be
     * placed. If omitted, the Go package will be derived from the following:
     *   - The basename of the package import path, if provided.
     *   - Otherwise, the package statement in the .proto file, if present.
     *   - Otherwise, the basename of the .proto file, without extension.
     *
     * Generated from protobuf field <code>optional string go_package = 11;</code>
     */
    protected $go_package = null;
    /**
     * Should generic services be generated in each language?  "Generic" services
     * are not specific to any particular RPC system.  They are generated by the
     * main code generators in each language (without additional plugins).
     * Generic services were the only kind of service generation supported by
     * early versions of google.protobuf.
     * Generic services are now considered deprecated in favor of using plugins
     * that generate code specific to your particular RPC system.  Therefore,
     * these default to false.  Old code which depends on generic services should
     * explicitly set them to true.
     *
     * Generated from protobuf field <code>optional bool cc_generic_services = 16 [default = false];</code>
     */
    protected $cc_generic_services = null;
    /**
     * Generated from protobuf field <code>optional bool java_generic_services = 17 [default = false];</code>
     */
    protected $java_generic_services = null;
    /**
     * Generated from protobuf field <code>optional bool py_generic_services = 18 [default = false];</code>
     */
    protected $py_generic_services = null;
    /**
     * Generated from protobuf field <code>optional bool php_generic_services = 42 [default = false];</code>
     */
    protected $php_generic_services = null;
    /**
     * Is this file deprecated?
     * Depending on the target platform, this can emit Deprecated annotations
     * for everything in the file, or it will be completely ignored; in the very
     * least, this is a formalization for deprecating files.
     *
     * Generated from protobuf field <code>optional bool deprecated = 23 [default = false];</code>
     */
    protected $deprecated = null;
    /**
     * Enables the use of arenas for the proto messages in this file. This applies
     * only to generated classes for C++.
     *
     * Generated from protobuf field <code>optional bool cc_enable_arenas = 31 [default = true];</code>
     */
    protected $cc_enable_arenas = null;
    /**
     * Sets the objective c class prefix which is prepended to all objective c
     * generated classes from this .proto. There is no default.
     *
     * Generated from protobuf field <code>optional string objc_class_prefix = 36;</code>
     */
    protected $objc_class_prefix = null;
    /**
     * Namespace for generated classes; defaults to the package.
     *
     * Generated from protobuf field <code>optional string csharp_namespace = 37;</code>
     */
    protected $csharp_namespace = null;
    /**
     * By default Swift generators will take the proto package and CamelCase it
     * replacing '.' with underscore and use that to prefix the types/symbols
     * defined. When this options is provided, they will use this value instead
     * to prefix the types/symbols defined.
     *
     * Generated from protobuf field <code>optional string swift_prefix = 39;</code>
     */
    protected $swift_prefix = null;
    /**
     * Sets the php class prefix which is prepended to all php generated classes
     * from this .proto. Default is empty.
     *
     * Generated from protobuf field <code>optional string php_class_prefix = 40;</code>
     */
    protected $php_class_prefix = null;
    /**
     * Use this option to change the namespace of php generated classes. Default
     * is empty. When this option is empty, the package name will be used for
     * determining the namespace.
     *
     * Generated from protobuf field <code>optional string php_namespace = 41;</code>
     */
    protected $php_namespace = null;
    /**
     * Use this option to change the namespace of php generated metadata classes.
     * Default is empty. When this option is empty, the proto file name will be
     * used for determining the namespace.
     *
     * Generated from protobuf field <code>optional string php_metadata_namespace = 44;</code>
     */
    protected $php_metadata_namespace = null;
    /**
     * Use this option to change the package of ruby generated classes. Default
     * is empty. When this option is not set, the package name will be used for
     * determining the ruby package.
     *
     * Generated from protobuf field <code>optional string ruby_package = 45;</code>
     */
    protected $ruby_package = null;
    /**
     * The parser stores options it doesn't recognize here.
     * See the documentation for the "Options" section above.
     *
     * Generated from protobuf field <code>repeated .google.protobuf.UninterpretedOption uninterpreted_option = 999;</code>
     */
    private $uninterpreted_option;
    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $java_package
     *           Sets the Java package where classes generated from this .proto will be
     *           placed.  By default, the proto package is used, but this is often
     *           inappropriate because proto packages do not normally start with backwards
     *           domain names.
     *     @type string $java_outer_classname
     *           Controls the name of the wrapper Java class generated for the .proto file.
     *           That class will always contain the .proto file's getDescriptor() method as
     *           well as any top-level extensions defined in the .proto file.
     *           If java_multiple_files is disabled, then all the other classes from the
     *           .proto file will be nested inside the single wrapper outer class.
     *     @type bool $java_multiple_files
     *           If enabled, then the Java code generator will generate a separate .java
     *           file for each top-level message, enum, and service defined in the .proto
     *           file.  Thus, these types will *not* be nested inside the wrapper class
     *           named by java_outer_classname.  However, the wrapper class will still be
     *           generated to contain the file's getDescriptor() method as well as any
     *           top-level extensions defined in the file.
     *     @type bool $java_generate_equals_and_hash
     *           This option does nothing.
     *     @type bool $java_string_check_utf8
     *           If set true, then the Java2 code generator will generate code that
     *           throws an exception whenever an attempt is made to assign a non-UTF-8
     *           byte sequence to a string field.
     *           Message reflection will do the same.
     *           However, an extension field still accepts non-UTF-8 byte sequences.
     *           This option has no effect on when used with the lite runtime.
     *     @type int $optimize_for
     *     @type string $go_package
     *           Sets the Go package where structs generated from this .proto will be
     *           placed. If omitted, the Go package will be derived from the following:
     *             - The basename of the package import path, if provided.
     *             - Otherwise, the package statement in the .proto file, if present.
     *             - Otherwise, the basename of the .proto file, without extension.
     *     @type bool $cc_generic_services
     *           Should generic services be generated in each language?  "Generic" services
     *           are not specific to any particular RPC system.  They are generated by the
     *           main code generators in each language (without additional plugins).
     *           Generic services were the only kind of service generation supported by
     *           early versions of google.protobuf.
     *           Generic services are now considered deprecated in favor of using plugins
     *           that generate code specific to your particular RPC system.  Therefore,
     *           these default to false.  Old code which depends on generic services should
     *           explicitly set them to true.
     *     @type bool $java_generic_services
     *     @type bool $py_generic_services
     *     @type bool $php_generic_services
     *     @type bool $deprecated
     *           Is this file deprecated?
     *           Depending on the target platform, this can emit Deprecated annotations
     *           for everything in the file, or it will be completely ignored; in the very
     *           least, this is a formalization for deprecating files.
     *     @type bool $cc_enable_arenas
     *           Enables the use of arenas for the proto messages in this file. This applies
     *           only to generated classes for C++.
     *     @type string $objc_class_prefix
     *           Sets the objective c class prefix which is prepended to all objective c
     *           generated classes from this .proto. There is no default.
     *     @type string $csharp_namespace
     *           Namespace for generated classes; defaults to the package.
     *     @type string $swift_prefix
     *           By default Swift generators will take the proto package and CamelCase it
     *           replacing '.' with underscore and use that to prefix the types/symbols
     *           defined. When this options is provided, they will use this value instead
     *           to prefix the types/symbols defined.
     *     @type string $php_class_prefix
     *           Sets the php class prefix which is prepended to all php generated classes
     *           from this .proto. Default is empty.
     *     @type string $php_namespace
     *           Use this option to change the namespace of php generated classes. Default
     *           is empty. When this option is empty, the package name will be used for
     *           determining the namespace.
     *     @type string $php_metadata_namespace
     *           Use this option to change the namespace of php generated metadata classes.
     *           Default is empty. When this option is empty, the proto file name will be
     *           used for determining the namespace.
     *     @type string $ruby_package
     *           Use this option to change the package of ruby generated classes. Default
     *           is empty. When this option is not set, the package name will be used for
     *           determining the ruby package.
     *     @type array<\Google\Protobuf\Internal\UninterpretedOption>|\Google\Protobuf\Internal\RepeatedField $uninterpreted_option
     *           The parser stores options it doesn't recognize here.
     *           See the documentation for the "Options" section above.
     * }
     */
    public function __construct($data = NULL)
    {
        \GPBMetadata\Google\Protobuf\Internal\Descriptor::initOnce();
        parent::__construct($data);
    }
    /**
     * Sets the Java package where classes generated from this .proto will be
     * placed.  By default, the proto package is used, but this is often
     * inappropriate because proto packages do not normally start with backwards
     * domain names.
     *
     * Generated from protobuf field <code>optional string java_package = 1;</code>
     * @return string
     */
    public function getJavaPackage()
    {
        return isset($this->java_package) ? $this->java_package : '';
    }
    public function hasJavaPackage()
    {
        return isset($this->java_package);
    }
    public function clearJavaPackage()
    {
        unset($this->java_package);
    }
    /**
     * Sets the Java package where classes generated from this .proto will be
     * placed.  By default, the proto package is used, but this is often
     * inappropriate because proto packages do not normally start with backwards
     * domain names.
     *
     * Generated from protobuf field <code>optional string java_package = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setJavaPackage($var)
    {
        GPBUtil::checkString($var, True);
        $this->java_package = $var;
        return $this;
    }
    /**
     * Controls the name of the wrapper Java class generated for the .proto file.
     * That class will always contain the .proto file's getDescriptor() method as
     * well as any top-level extensions defined in the .proto file.
     * If java_multiple_files is disabled, then all the other classes from the
     * .proto file will be nested inside the single wrapper outer class.
     *
     * Generated from protobuf field <code>optional string java_outer_classname = 8;</code>
     * @return string
     */
    public function getJavaOuterClassname()
    {
        return isset($this->java_outer_classname) ? $this->java_outer_classname : '';
    }
    public function hasJavaOuterClassname()
    {
        return isset($this->java_outer_classname);
    }
    public function clearJavaOuterClassname()
    {
        unset($this->java_outer_classname);
    }
    /**
     * Controls the name of the wrapper Java class generated for the .proto file.
     * That class will always contain the .proto file's getDescriptor() method as
     * well as any top-level extensions defined in the .proto file.
     * If java_multiple_files is disabled, then all the other classes from the
     * .proto file will be nested inside the single wrapper outer class.
     *
     * Generated from protobuf field <code>optional string java_outer_classname = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setJavaOuterClassname($var)
    {
        GPBUtil::checkString($var, True);
        $this->java_outer_classname = $var;
        return $this;
    }
    /**
     * If enabled, then the Java code generator will generate a separate .java
     * file for each top-level message, enum, and service defined in the .proto
     * file.  Thus, these types will *not* be nested inside the wrapper class
     * named by java_outer_classname.  However, the wrapper class will still be
     * generated to contain the file's getDescriptor() method as well as any
     * top-level extensions defined in the file.
     *
     * Generated from protobuf field <code>optional bool java_multiple_files = 10 [default = false];</code>
     * @return bool
     */
    public function getJavaMultipleFiles()
    {
        return isset($this->java_multiple_files) ? $this->java_multiple_files : \false;
    }
    public function hasJavaMultipleFiles()
    {
        return isset($this->java_multiple_files);
    }
    public function clearJavaMultipleFiles()
    {
        unset($this->java_multiple_files);
    }
    /**
     * If enabled, then the Java code generator will generate a separate .java
     * file for each top-level message, enum, and service defined in the .proto
     * file.  Thus, these types will *not* be nested inside the wrapper class
     * named by java_outer_classname.  However, the wrapper class will still be
     * generated to contain the file's getDescriptor() method as well as any
     * top-level extensions defined in the file.
     *
     * Generated from protobuf field <code>optional bool java_multiple_files = 10 [default = false];</code>
     * @param bool $var
     * @return $this
     */
    public function setJavaMultipleFiles($var)
    {
        GPBUtil::checkBool($var);
        $this->java_multiple_files = $var;
        return $this;
    }
    /**
     * This option does nothing.
     *
     * Generated from protobuf field <code>optional bool java_generate_equals_and_hash = 20 [deprecated = true];</code>
     * @return bool
     * @deprecated
     */
    public function getJavaGenerateEqualsAndHash()
    {
        @\trigger_error('java_generate_equals_and_hash is deprecated.', \E_USER_DEPRECATED);
        return isset($this->java_generate_equals_and_hash) ? $this->java_generate_equals_and_hash : \false;
    }
    public function hasJavaGenerateEqualsAndHash()
    {
        @\trigger_error('java_generate_equals_and_hash is deprecated.', \E_USER_DEPRECATED);
        return isset($this->java_generate_equals_and_hash);
    }
    public function clearJavaGenerateEqualsAndHash()
    {
        @\trigger_error('java_generate_equals_and_hash is deprecated.', \E_USER_DEPRECATED);
        unset($this->java_generate_equals_and_hash);
    }
    /**
     * This option does nothing.
     *
     * Generated from protobuf field <code>optional bool java_generate_equals_and_hash = 20 [deprecated = true];</code>
     * @param bool $var
     * @return $this
     * @deprecated
     */
    public function setJavaGenerateEqualsAndHash($var)
    {
        @\trigger_error('java_generate_equals_and_hash is deprecated.', \E_USER_DEPRECATED);
        GPBUtil::checkBool($var);
        $this->java_generate_equals_and_hash = $var;
        return $this;
    }
    /**
     * If set true, then the Java2 code generator will generate code that
     * throws an exception whenever an attempt is made to assign a non-UTF-8
     * byte sequence to a string field.
     * Message reflection will do the same.
     * However, an extension field still accepts non-UTF-8 byte sequences.
     * This option has no effect on when used with the lite runtime.
     *
     * Generated from protobuf field <code>optional bool java_string_check_utf8 = 27 [default = false];</code>
     * @return bool
     */
    public function getJavaStringCheckUtf8()
    {
        return isset($this->java_string_check_utf8) ? $this->java_string_check_utf8 : \false;
    }
    public function hasJavaStringCheckUtf8()
    {
        return isset($this->java_string_check_utf8);
    }
    public function clearJavaStringCheckUtf8()
    {
        unset($this->java_string_check_utf8);
    }
    /**
     * If set true, then the Java2 code generator will generate code that
     * throws an exception whenever an attempt is made to assign a non-UTF-8
     * byte sequence to a string field.
     * Message reflection will do the same.
     * However, an extension field still accepts non-UTF-8 byte sequences.
     * This option has no effect on when used with the lite runtime.
     *
     * Generated from protobuf field <code>optional bool java_string_check_utf8 = 27 [default = false];</code>
     * @param bool $var
     * @return $this
     */
    public function setJavaStringCheckUtf8($var)
    {
        GPBUtil::checkBool($var);
        $this->java_string_check_utf8 = $var;
        return $this;
    }
    /**
     * Generated from protobuf field <code>optional .google.protobuf.FileOptions.OptimizeMode optimize_for = 9 [default = SPEED];</code>
     * @return int
     */
    public function getOptimizeFor()
    {
        return isset($this->optimize_for) ? $this->optimize_for : 0;
    }
    public function hasOptimizeFor()
    {
        return isset($this->optimize_for);
    }
    public function clearOptimizeFor()
    {
        unset($this->optimize_for);
    }
    /**
     * Generated from protobuf field <code>optional .google.protobuf.FileOptions.OptimizeMode optimize_for = 9 [default = SPEED];</code>
     * @param int $var
     * @return $this
     */
    public function setOptimizeFor($var)
    {
        GPBUtil::checkEnum($var, \Google\Protobuf\Internal\FileOptions\OptimizeMode::class);
        $this->optimize_for = $var;
        return $this;
    }
    /**
     * Sets the Go package where structs generated from this .proto will be
     * placed. If omitted, the Go package will be derived from the following:
     *   - The basename of the package import path, if provided.
     *   - Otherwise, the package statement in the .proto file, if present.
     *   - Otherwise, the basename of the .proto file, without extension.
     *
     * Generated from protobuf field <code>optional string go_package = 11;</code>
     * @return string
     */
    public function getGoPackage()
    {
        return isset($this->go_package) ? $this->go_package : '';
    }
    public function hasGoPackage()
    {
        return isset($this->go_package);
    }
    public function clearGoPackage()
    {
        unset($this->go_package);
    }
    /**
     * Sets the Go package where structs generated from this .proto will be
     * placed. If omitted, the Go package will be derived from the following:
     *   - The basename of the package import path, if provided.
     *   - Otherwise, the package statement in the .proto file, if present.
     *   - Otherwise, the basename of the .proto file, without extension.
     *
     * Generated from protobuf field <code>optional string go_package = 11;</code>
     * @param string $var
     * @return $this
     */
    public function setGoPackage($var)
    {
        GPBUtil::checkString($var, True);
        $this->go_package = $var;
        return $this;
    }
    /**
     * Should generic services be generated in each language?  "Generic" services
     * are not specific to any particular RPC system.  They are generated by the
     * main code generators in each language (without additional plugins).
     * Generic services were the only kind of service generation supported by
     * early versions of google.protobuf.
     * Generic services are now considered deprecated in favor of using plugins
     * that generate code specific to your particular RPC system.  Therefore,
     * these default to false.  Old code which depends on generic services should
     * explicitly set them to true.
     *
     * Generated from protobuf field <code>optional bool cc_generic_services = 16 [default = false];</code>
     * @return bool
     */
    public function getCcGenericServices()
    {
        return isset($this->cc_generic_services) ? $this->cc_generic_services : \false;
    }
    public function hasCcGenericServices()
    {
        return isset($this->cc_generic_services);
    }
    public function clearCcGenericServices()
    {
        unset($this->cc_generic_services);
    }
    /**
     * Should generic services be generated in each language?  "Generic" services
     * are not specific to any particular RPC system.  They are generated by the
     * main code generators in each language (without additional plugins).
     * Generic services were the only kind of service generation supported by
     * early versions of google.protobuf.
     * Generic services are now considered deprecated in favor of using plugins
     * that generate code specific to your particular RPC system.  Therefore,
     * these default to false.  Old code which depends on generic services should
     * explicitly set them to true.
     *
     * Generated from protobuf field <code>optional bool cc_generic_services = 16 [default = false];</code>
     * @param bool $var
     * @return $this
     */
    public function setCcGenericServices($var)
    {
        GPBUtil::checkBool($var);
        $this->cc_generic_services = $var;
        return $this;
    }
    /**
     * Generated from protobuf field <code>optional bool java_generic_services = 17 [default = false];</code>
     * @return bool
     */
    public function getJavaGenericServices()
    {
        return isset($this->java_generic_services) ? $this->java_generic_services : \false;
    }
    public function hasJavaGenericServices()
    {
        return isset($this->java_generic_services);
    }
    public function clearJavaGenericServices()
    {
        unset($this->java_generic_services);
    }
    /**
     * Generated from protobuf field <code>optional bool java_generic_services = 17 [default = false];</code>
     * @param bool $var
     * @return $this
     */
    public function setJavaGenericServices($var)
    {
        GPBUtil::checkBool($var);
        $this->java_generic_services = $var;
        return $this;
    }
    /**
     * Generated from protobuf field <code>optional bool py_generic_services = 18 [default = false];</code>
     * @return bool
     */
    public function getPyGenericServices()
    {
        return isset($this->py_generic_services) ? $this->py_generic_services : \false;
    }
    public function hasPyGenericServices()
    {
        return isset($this->py_generic_services);
    }
    public function clearPyGenericServices()
    {
        unset($this->py_generic_services);
    }
    /**
     * Generated from protobuf field <code>optional bool py_generic_services = 18 [default = false];</code>
     * @param bool $var
     * @return $this
     */
    public function setPyGenericServices($var)
    {
        GPBUtil::checkBool($var);
        $this->py_generic_services = $var;
        return $this;
    }
    /**
     * Generated from protobuf field <code>optional bool php_generic_services = 42 [default = false];</code>
     * @return bool
     */
    public function getPhpGenericServices()
    {
        return isset($this->php_generic_services) ? $this->php_generic_services : \false;
    }
    public function hasPhpGenericServices()
    {
        return isset($this->php_generic_services);
    }
    public function clearPhpGenericServices()
    {
        unset($this->php_generic_services);
    }
    /**
     * Generated from protobuf field <code>optional bool php_generic_services = 42 [default = false];</code>
     * @param bool $var
     * @return $this
     */
    public function setPhpGenericServices($var)
    {
        GPBUtil::checkBool($var);
        $this->php_generic_services = $var;
        return $this;
    }
    /**
     * Is this file deprecated?
     * Depending on the target platform, this can emit Deprecated annotations
     * for everything in the file, or it will be completely ignored; in the very
     * least, this is a formalization for deprecating files.
     *
     * Generated from protobuf field <code>optional bool deprecated = 23 [default = false];</code>
     * @return bool
     */
    public function getDeprecated()
    {
        return isset($this->deprecated) ? $this->deprecated : \false;
    }
    public function hasDeprecated()
    {
        return isset($this->deprecated);
    }
    public function clearDeprecated()
    {
        unset($this->deprecated);
    }
    /**
     * Is this file deprecated?
     * Depending on the target platform, this can emit Deprecated annotations
     * for everything in the file, or it will be completely ignored; in the very
     * least, this is a formalization for deprecating files.
     *
     * Generated from protobuf field <code>optional bool deprecated = 23 [default = false];</code>
     * @param bool $var
     * @return $this
     */
    public function setDeprecated($var)
    {
        GPBUtil::checkBool($var);
        $this->deprecated = $var;
        return $this;
    }
    /**
     * Enables the use of arenas for the proto messages in this file. This applies
     * only to generated classes for C++.
     *
     * Generated from protobuf field <code>optional bool cc_enable_arenas = 31 [default = true];</code>
     * @return bool
     */
    public function getCcEnableArenas()
    {
        return isset($this->cc_enable_arenas) ? $this->cc_enable_arenas : \false;
    }
    public function hasCcEnableArenas()
    {
        return isset($this->cc_enable_arenas);
    }
    public function clearCcEnableArenas()
    {
        unset($this->cc_enable_arenas);
    }
    /**
     * Enables the use of arenas for the proto messages in this file. This applies
     * only to generated classes for C++.
     *
     * Generated from protobuf field <code>optional bool cc_enable_arenas = 31 [default = true];</code>
     * @param bool $var
     * @return $this
     */
    public function setCcEnableArenas($var)
    {
        GPBUtil::checkBool($var);
        $this->cc_enable_arenas = $var;
        return $this;
    }
    /**
     * Sets the objective c class prefix which is prepended to all objective c
     * generated classes from this .proto. There is no default.
     *
     * Generated from protobuf field <code>optional string objc_class_prefix = 36;</code>
     * @return string
     */
    public function getObjcClassPrefix()
    {
        return isset($this->objc_class_prefix) ? $this->objc_class_prefix : '';
    }
    public function hasObjcClassPrefix()
    {
        return isset($this->objc_class_prefix);
    }
    public function clearObjcClassPrefix()
    {
        unset($this->objc_class_prefix);
    }
    /**
     * Sets the objective c class prefix which is prepended to all objective c
     * generated classes from this .proto. There is no default.
     *
     * Generated from protobuf field <code>optional string objc_class_prefix = 36;</code>
     * @param string $var
     * @return $this
     */
    public function setObjcClassPrefix($var)
    {
        GPBUtil::checkString($var, True);
        $this->objc_class_prefix = $var;
        return $this;
    }
    /**
     * Namespace for generated classes; defaults to the package.
     *
     * Generated from protobuf field <code>optional string csharp_namespace = 37;</code>
     * @return string
     */
    public function getCsharpNamespace()
    {
        return isset($this->csharp_namespace) ? $this->csharp_namespace : '';
    }
    public function hasCsharpNamespace()
    {
        return isset($this->csharp_namespace);
    }
    public function clearCsharpNamespace()
    {
        unset($this->csharp_namespace);
    }
    /**
     * Namespace for generated classes; defaults to the package.
     *
     * Generated from protobuf field <code>optional string csharp_namespace = 37;</code>
     * @param string $var
     * @return $this
     */
    public function setCsharpNamespace($var)
    {
        GPBUtil::checkString($var, True);
        $this->csharp_namespace = $var;
        return $this;
    }
    /**
     * By default Swift generators will take the proto package and CamelCase it
     * replacing '.' with underscore and use that to prefix the types/symbols
     * defined. When this options is provided, they will use this value instead
     * to prefix the types/symbols defined.
     *
     * Generated from protobuf field <code>optional string swift_prefix = 39;</code>
     * @return string
     */
    public function getSwiftPrefix()
    {
        return isset($this->swift_prefix) ? $this->swift_prefix : '';
    }
    public function hasSwiftPrefix()
    {
        return isset($this->swift_prefix);
    }
    public function clearSwiftPrefix()
    {
        unset($this->swift_prefix);
    }
    /**
     * By default Swift generators will take the proto package and CamelCase it
     * replacing '.' with underscore and use that to prefix the types/symbols
     * defined. When this options is provided, they will use this value instead
     * to prefix the types/symbols defined.
     *
     * Generated from protobuf field <code>optional string swift_prefix = 39;</code>
     * @param string $var
     * @return $this
     */
    public function setSwiftPrefix($var)
    {
        GPBUtil::checkString($var, True);
        $this->swift_prefix = $var;
        return $this;
    }
    /**
     * Sets the php class prefix which is prepended to all php generated classes
     * from this .proto. Default is empty.
     *
     * Generated from protobuf field <code>optional string php_class_prefix = 40;</code>
     * @return string
     */
    public function getPhpClassPrefix()
    {
        return isset($this->php_class_prefix) ? $this->php_class_prefix : '';
    }
    public function hasPhpClassPrefix()
    {
        return isset($this->php_class_prefix);
    }
    public function clearPhpClassPrefix()
    {
        unset($this->php_class_prefix);
    }
    /**
     * Sets the php class prefix which is prepended to all php generated classes
     * from this .proto. Default is empty.
     *
     * Generated from protobuf field <code>optional string php_class_prefix = 40;</code>
     * @param string $var
     * @return $this
     */
    public function setPhpClassPrefix($var)
    {
        GPBUtil::checkString($var, True);
        $this->php_class_prefix = $var;
        return $this;
    }
    /**
     * Use this option to change the namespace of php generated classes. Default
     * is empty. When this option is empty, the package name will be used for
     * determining the namespace.
     *
     * Generated from protobuf field <code>optional string php_namespace = 41;</code>
     * @return string
     */
    public function getPhpNamespace()
    {
        return isset($this->php_namespace) ? $this->php_namespace : '';
    }
    public function hasPhpNamespace()
    {
        return isset($this->php_namespace);
    }
    public function clearPhpNamespace()
    {
        unset($this->php_namespace);
    }
    /**
     * Use this option to change the namespace of php generated classes. Default
     * is empty. When this option is empty, the package name will be used for
     * determining the namespace.
     *
     * Generated from protobuf field <code>optional string php_namespace = 41;</code>
     * @param string $var
     * @return $this
     */
    public function setPhpNamespace($var)
    {
        GPBUtil::checkString($var, True);
        $this->php_namespace = $var;
        return $this;
    }
    /**
     * Use this option to change the namespace of php generated metadata classes.
     * Default is empty. When this option is empty, the proto file name will be
     * used for determining the namespace.
     *
     * Generated from protobuf field <code>optional string php_metadata_namespace = 44;</code>
     * @return string
     */
    public function getPhpMetadataNamespace()
    {
        return isset($this->php_metadata_namespace) ? $this->php_metadata_namespace : '';
    }
    public function hasPhpMetadataNamespace()
    {
        return isset($this->php_metadata_namespace);
    }
    public function clearPhpMetadataNamespace()
    {
        unset($this->php_metadata_namespace);
    }
    /**
     * Use this option to change the namespace of php generated metadata classes.
     * Default is empty. When this option is empty, the proto file name will be
     * used for determining the namespace.
     *
     * Generated from protobuf field <code>optional string php_metadata_namespace = 44;</code>
     * @param string $var
     * @return $this
     */
    public function setPhpMetadataNamespace($var)
    {
        GPBUtil::checkString($var, True);
        $this->php_metadata_namespace = $var;
        return $this;
    }
    /**
     * Use this option to change the package of ruby generated classes. Default
     * is empty. When this option is not set, the package name will be used for
     * determining the ruby package.
     *
     * Generated from protobuf field <code>optional string ruby_package = 45;</code>
     * @return string
     */
    public function getRubyPackage()
    {
        return isset($this->ruby_package) ? $this->ruby_package : '';
    }
    public function hasRubyPackage()
    {
        return isset($this->ruby_package);
    }
    public function clearRubyPackage()
    {
        unset($this->ruby_package);
    }
    /**
     * Use this option to change the package of ruby generated classes. Default
     * is empty. When this option is not set, the package name will be used for
     * determining the ruby package.
     *
     * Generated from protobuf field <code>optional string ruby_package = 45;</code>
     * @param string $var
     * @return $this
     */
    public function setRubyPackage($var)
    {
        GPBUtil::checkString($var, True);
        $this->ruby_package = $var;
        return $this;
    }
    /**
     * The parser stores options it doesn't recognize here.
     * See the documentation for the "Options" section above.
     *
     * Generated from protobuf field <code>repeated .google.protobuf.UninterpretedOption uninterpreted_option = 999;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getUninterpretedOption()
    {
        return $this->uninterpreted_option;
    }
    /**
     * The parser stores options it doesn't recognize here.
     * See the documentation for the "Options" section above.
     *
     * Generated from protobuf field <code>repeated .google.protobuf.UninterpretedOption uninterpreted_option = 999;</code>
     * @param array<\Google\Protobuf\Internal\UninterpretedOption>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setUninterpretedOption($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Protobuf\Internal\UninterpretedOption::class);
        $this->uninterpreted_option = $arr;
        return $this;
    }
}
