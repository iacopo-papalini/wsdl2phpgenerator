<?php
/**
 * @package phpSource
 */

/**
 * Abstract base class for all PHP elements, variables, functions and classes etc.
 *
 * @package phpSource
 * @author Fredrik Wallgren <fredrik.wallgren@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
abstract class PhpElement
{
  /**
   * These strings cannot be used as function or class names
   * @see http://www.php.net/manual/en/reserved.keywords.php
   */
  const PHP_RESERVED = "|__halt_compiler|abstract|and|array|as|break|callable|case|catch|class|clone|const|continue|declare|default|die|do|echo|else|elseif|empty|enddeclare|endfor|endforeach|endif|endswitch|endwhile|eval|exit|extends|final|for|foreach|function|global|goto|if|implements|include|include_once|instanceof|insteadof|interface|isset|list|namespace|new|or|print|private|protected|public|require|require_once|return|static|switch|throw|trait|try|unset|use|var|while|xor|";

  protected static function bonifyIdentifier ($identifier)
  {
    if (strpos(self::PHP_RESERVED, strtolower("|$identifier|")) !== false)
    {
      $identifier .= "_";
    }
    return $identifier;
  }

  /**
   *
   * @var string The access of the function |public|private|protected
   * @access protected
   */
  protected $access;

  /**
   *
   * @var string The identifier of the element
   * @access protected
   */
  protected $identifier;

  /**
   *
   * @var string The string to use for indention for the element
   */
  protected $indentionStr;

  /**
   * Function to be overloaded, return the source code of the specialized element
   *
   * @access public
   * @return string
   */
  abstract public function getSource();

  /**
   *
   * @return string The access of the element
   */
  public function getAccess()
  {
    return $this->access;
  }

  /**
   *
   * @return string The identifier, name, of the element
   */
  public function getIdentifier()
  {
    return $this->identifier;
  }

  /**
   *
   * @return string Returns the indention string
   */
  public function getIndentionStr()
  {
    return $this->indentionStr;
  }

  /**
   *
   * @param string $indentionStr Sets the indention string to use
   */
  public function setIndentionStr($indentionStr)
  {
    $this->indentionStr = $indentionStr;
  }

  /**
   * Takes a string and prepends ith with the current indention string
   * Has support for multiple lines
   *
   * @param string $source
   * @return string
   */
  public function getSourceRow($source)
  {
    if (strpos($source, PHP_EOL) === false)
    {
      return $this->indentionStr.$source.PHP_EOL;
    }

    $ret = '';
    $rows = explode(PHP_EOL, $source);
    if (strlen(trim($rows[0])) == 0)
    {
      $rows = array_splice($rows, 1);
    }
    if (strlen(trim($rows[(count($rows) - 1)])) == 0)
    {
      $rows = array_splice($rows, 0, count($rows) - 1);
    }
    foreach ($rows as $row)
    {
      $ret .= $this->indentionStr.$row.PHP_EOL;
    }

    return $ret;
  }
}

