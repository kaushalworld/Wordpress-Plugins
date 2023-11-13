<?php

class BrizyPro_Whitelabel_Value implements Serializable {

	const TYPE_TEXT = 'text';
	const TYPE_IMAGE = 'image';

	/**
	 * @var string
	 */
	private $key;

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @var string
	 */
	private $type;

	/**
	 * @var string
	 */
	private $label;

	/**
	 * BrizyPro_Whitelabel_Value constructor.
	 *
	 * @param $key
	 * @param $type
	 * @param $value
	 * @param string $label
	 */
	public function __construct( $key, $type, $value, $label = '' ) {
		$this->setKey( $key );
		$this->setValue( $value );
		$this->setType( $type );
		$this->setLabel( $label );
	}

	/**
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * @param string $key
	 *
	 * @return BrizyPro_Whitelabel_Value
	 */
	public function setKey( $key ) {
		$this->key = $key;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param string $value
	 *
	 * @return BrizyPro_Whitelabel_Value
	 */
	public function setValue( $value ) {
		$this->value = $value;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 *
	 * @return BrizyPro_Whitelabel_Value
	 */
	public function setType( $type ) {
		$this->type = $type;

		return $this;
	}

	/**
	 * @return string
	 */
	public function serialize() {
		return serialize( $this->jsonSerialize() );
	}

	/**
	 * @return string
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @param string $label
	 *
	 * @return BrizyPro_Whitelabel_Value
	 */
	public function setLabel( $label ) {
		$this->label = $label;

		return $this;
	}

	/**
	 * @param string $data
	 *
	 * @return void
	 */
	public function unserialize( $data ) {
		$data = unserialize( $data );

		$this->setValue( $data['value'] );
		$this->setType( $data['type'] );
	}

	public function __serialize() {
		return $this->jsonSerialize();
	}

	public function __unserialize( $data ) {
		$this->setValue( $data['value'] );
		$this->setType( $data['type'] );
	}

	public function jsonSerialize() {
		return [
			'value' => $this->getValue(),
			'type'  => $this->getType()
		];
	}
}