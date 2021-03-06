<?php
/**
 * @file ATTENTION!!! The code below was carefully crafted by a mean machine.
 * Please consider to NOT put any emotional human-generated modifications as the splendid AI will throw them away with no mercy.
 */

namespace Swaggest\PhpCodeBuilder\Tests\Tmp\SwaggerMin;

use Swaggest\JsonSchema\Constraint\Properties;
use Swaggest\JsonSchema\Context;
use Swaggest\JsonSchema\Schema;
use Swaggest\JsonSchema\Structure\ClassStructure;


/**
 * Built from #/definitions/oauth2PasswordSecurity
 * @method static Oauth2PasswordSecurity import($data, Context $options=null)
 */
class Oauth2PasswordSecurity extends ClassStructure {
	const OAUTH2 = 'oauth2';

	const PASSWORD = 'password';

	/** @var string */
	public $type;

	/** @var string */
	public $flow;

	/** @var string[] */
	public $scopes;

	/** @var string */
	public $tokenUrl;

	/** @var string */
	public $description;

	/**
	 * @param Properties|static $properties
	 * @param Schema $ownerSchema
	 */
	public static function setUpProperties($properties, Schema $ownerSchema)
	{
		$properties->type = Schema::string();
		$properties->type->enum = array(
		    self::OAUTH2,
		);
		$properties->flow = Schema::string();
		$properties->flow->enum = array(
		    self::PASSWORD,
		);
		$properties->scopes = Schema::object();
		$properties->scopes->additionalProperties = Schema::string();
		$properties->scopes->setFromRef('#/definitions/oauth2Scopes');
		$properties->tokenUrl = Schema::string();
		$properties->tokenUrl->format = "uri";
		$properties->description = Schema::string();
		$ownerSchema->type = 'object';
		$ownerSchema->additionalProperties = false;
		$patternProperty = new Schema();
		$patternProperty->additionalProperties = true;
		$patternProperty->additionalItems = true;
		$patternProperty->description = "Any property starting with x- is valid.";
		$patternProperty->setFromRef('#/definitions/vendorExtension');
		$ownerSchema->setPatternProperty('^x-', $patternProperty);
		$ownerSchema->required = array (
		  0 => 'type',
		  1 => 'flow',
		  2 => 'tokenUrl',
		);
		$ownerSchema->setFromRef('#/definitions/oauth2PasswordSecurity');
	}

	/**
	 * @param string $type
	 * @return $this
	 * @codeCoverageIgnoreStart
	 */
	public function setType($type)
	{
		$this->type = $type;
		return $this;
	}
	/** @codeCoverageIgnoreEnd */

	/**
	 * @param string $flow
	 * @return $this
	 * @codeCoverageIgnoreStart
	 */
	public function setFlow($flow)
	{
		$this->flow = $flow;
		return $this;
	}
	/** @codeCoverageIgnoreEnd */

	/**
	 * @param string[] $scopes
	 * @return $this
	 * @codeCoverageIgnoreStart
	 */
	public function setScopes($scopes)
	{
		$this->scopes = $scopes;
		return $this;
	}
	/** @codeCoverageIgnoreEnd */

	/**
	 * @param string $tokenUrl
	 * @return $this
	 * @codeCoverageIgnoreStart
	 */
	public function setTokenUrl($tokenUrl)
	{
		$this->tokenUrl = $tokenUrl;
		return $this;
	}
	/** @codeCoverageIgnoreEnd */

	/**
	 * @param string $description
	 * @return $this
	 * @codeCoverageIgnoreStart
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}
	/** @codeCoverageIgnoreEnd */
}