<?php
/**
 * PHPWord
 *
 * Copyright (c) 2014 PHPWord
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPWord
 * @package    PHPWord
 * @copyright  Copyright (c) 2014 PHPWord
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    0.8.0
 */

namespace PhpOffice;

use PhpOffice\PhpWord\DocumentProperties;
use PhpOffice\PhpWord\Section;
use PhpOffice\PhpWord\Style;
use PhpOffice\PhpWord\Template;

/** PHPWORD_BASE_PATH */
// @codeCoverageIgnoreStart
if (!defined('PHPWORD_BASE_PATH')) {
    define('PHPWORD_BASE_PATH', dirname(__FILE__) . '/');
    require PHPWORD_BASE_PATH . 'PHPWord/Autoloader.php';
    PHPWord_Autoloader::Register();
}
// @codeCoverageIgnoreEnd

use PhpOffice\PhpWord\Exceptions\Exception;

class PhpWord
{
    /**
     * Default font name (Arial)
     */
    const DEFAULT_FONT_NAME = 'Arial';
    /**
     * Default Font Content Type(default)
     * default|eastAsia|cs
     */
    const DEFAULT_FONT_CONTENT_TYPE='default';
    /**
     * Default font size in points (10pt)
     *
     * OOXML defined font size values in halfpoints, i.e. twice of what PHPWord
     * use, and the conversion will be conducted during XML writing.
     */
    const DEFAULT_FONT_SIZE = 10;

    /**
     * Default font color (black)
     */
    const DEFAULT_FONT_COLOR = '000000';

    /**
     * Document properties
     *
     * @var PhpOffice\PhpWord\DocumentProperties
     */
    private $_properties;

    /**
     * Default Font Name
     *
     * @var string
     */
    private $_defaultFontName;

    /**
     * Default Font Size
     *
     * @var int
     */
    private $_defaultFontSize;

    /**
     * Collection of section elements
     *
     * @var array
     */
    private $_sectionCollection = array();


    /**
     * Create a new PHPWord Document
     */
    public function __construct()
    {
        $this->_properties = new DocumentProperties();
        $this->_defaultFontName = PHPWord::DEFAULT_FONT_NAME;
        $this->_defaultFontSize = PHPWord::DEFAULT_FONT_SIZE;
    }

    /**
     * Get properties
     * @return PhpOffice\PhpWord\DocumentProperties
     */
    public function getProperties()
    {
        return $this->_properties;
    }

    /**
     * Set properties
     *
     * @param PhpOffice\PhpWord\DocumentProperties $value
     * @return PhpOffice\PHPWord
     */
    public function setProperties(DocumentProperties $value)
    {
        $this->_properties = $value;
        return $this;
    }

    /**
     * Create a new Section
     *
     * @param PhpOffice\PhpWord\Section\Settings $settings
     * @return PhpOffice\PhpWord\Section
     */
    public function createSection($settings = null)
    {
        $sectionCount = $this->_countSections() + 1;

        $section = new Section($sectionCount, $settings);
        $this->_sectionCollection[] = $section;
        return $section;
    }

    /**
     * Get default Font name
     * @return string
     */
    public function getDefaultFontName()
    {
        return $this->_defaultFontName;
    }

    /**
     * Set default Font name
     * @param string $pValue
     */
    public function setDefaultFontName($pValue)
    {
        $this->_defaultFontName = $pValue;
    }

    /**
     * Get default Font size (in points)
     * @return string
     */
    public function getDefaultFontSize()
    {
        return $this->_defaultFontSize;
    }

    /**
     * Set default Font size (in points)
     * @param int $pValue
     */
    public function setDefaultFontSize($pValue)
    {
        $this->_defaultFontSize = $pValue;
    }

    /**
     * Set default paragraph style definition to styles.xml
     *
     * @param   array   $styles Paragraph style definition
     */
    public function setDefaultParagraphStyle($styles)
    {
        Style::setDefaultParagraphStyle($styles);
    }

    /**
     * Adds a paragraph style definition to styles.xml
     *
     * @param $styleName string
     * @param $styles array
     */
    public function addParagraphStyle($styleName, $styles)
    {
        Style::addParagraphStyle($styleName, $styles);
    }

    /**
     * Adds a font style definition to styles.xml
     *
     * @param $styleName string
     * @param $styles array
     */
    public function addFontStyle($styleName, $styleFont, $styleParagraph = null)
    {
        Style::addFontStyle($styleName, $styleFont, $styleParagraph);
    }

    /**
     * Adds a table style definition to styles.xml
     *
     * @param $styleName string
     * @param $styles array
     */
    public function addTableStyle($styleName, $styleTable, $styleFirstRow = null)
    {
        Style::addTableStyle($styleName, $styleTable, $styleFirstRow);
    }

    /**
     * Adds a heading style definition to styles.xml
     *
     * @param $titleCount int
     * @param $styles array
     */
    public function addTitleStyle($titleCount, $styleFont, $styleParagraph = null)
    {
        Style::addTitleStyle($titleCount, $styleFont, $styleParagraph);
    }

    /**
     * Adds a hyperlink style to styles.xml
     *
     * @param $styleName string
     * @param $styles array
     */
    public function addLinkStyle($styleName, $styles)
    {
        Style::addLinkStyle($styleName, $styles);
    }

    /**
     * Get sections
     * @return PhpOffice\PhpWord\Section[]
     */
    public function getSections()
    {
        return $this->_sectionCollection;
    }

    /**
     * Load a Template File
     *
     * @param string $strFilename
     * @return PhpOffice\PhpWord\Template
     * @throws Exception
     */
    public function loadTemplate($strFilename)
    {
        if (file_exists($strFilename)) {
            return new Template($strFilename);
        }
        throw new Exception("Template file {$strFilename} not found.");
    }

    /**
     * Get section count
     * @return int
     */
    private function _countSections()
    {
        return count($this->_sectionCollection);
    }
}
