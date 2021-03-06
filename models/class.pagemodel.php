<?php defined('APPLICATION') or exit();
/**
 * Copyright (C) 2013-2018  Austin S.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Page Model
 */
class PageModel extends Gdn_Model {
    /**
     * Class constructor. Defines the related database table name.
     *
     * @param string $Name Database table name.
     */
    public function __construct() {
        parent::__construct('Page');
    }

    /** @var string Route suffixes for expression and target. */
    public $RouteExpressionSuffix = '$';
    public $RouteTargetSuffix = '';

    /**
     * Get data for a single page by ID.
     *
     * @param int $PageID ; Unique ID of page to get.
     * @return object $Page; SQL result.
     */
    public function GetByID($PageID) {
        $Page = $this->SQL
            ->Select('p.*')
            ->From('Page p')
            ->Where('p.PageID', $PageID)
            ->Get()
            ->FirstRow();

        if (!$Page)
            return null;

        return $Page;
    }

    /**
     * Get data for a single page by UrlCode.
     *
     * @param int $UrlCode ; Unique UrlCode of page to get.
     * @return object $Page; SQL result.
     */
    public function GetByUrlCode($UrlCode) {
        $Page = $this->SQL
            ->Select('p.*')
            ->From('Page p')
            ->Where('p.UrlCode', $UrlCode)
            ->Get()
            ->FirstRow();

        if (!$Page)
            return null;

        return $Page;
    }

    /**
     * Get list of all pages with SiteMenuLink column set to 1.
     *
     * @param int $UrlCode ; Unique UrlCode of page to get.
     * @return object $Page; SQL result.
     */
    public function GetAllSiteMenuLink() {
        $Page = $this->SQL
            ->Select('p.PageID', '', 'PageID')
            ->Select('p.Name', '', 'Name')
            ->Select('p.UrlCode', '', 'UrlCode')
            ->Select('p.ViewPermission', '', 'ViewPermission')
            ->From('Page p')
            ->Where('p.SiteMenuLink', '1')
            ->OrderBy('Sort', 'asc')
            ->Get();

        return $Page;
    }

    public function GetLastSort() {
        $LastSort = $this->SQL
            ->Select('p.Sort', 'MAX')
            ->From('Page p')
            ->Get()
            ->FirstRow()
            ->Sort;

        return $LastSort;
    }

    /**
     * Return a url for a page.
     *
     * @param object $UrlCode ; Page URL code.
     * @param object $WithDomain ; Return with domain in URL.
     * @return string; The URL to the page.
     */
    public static function PageUrl($UrlCode, $WithDomain = true) {
        if(is_array($UrlCode))
            $UrlCode = $UrlCode['UrlCode'];
        else if(is_object($UrlCode))
            $UrlCode = $UrlCode->UrlCode;

        $PageModel = new PageModel();
        if (Gdn::Router()->MatchRoute($UrlCode . $PageModel->RouteExpressionSuffix)) {
            $Result = rawurlencode($UrlCode);
        } else {
            $Result = '/page/' . rawurlencode($UrlCode);
        }

        return Url($Result, $WithDomain);
    }
}
