<?php
if (!defined('APPLICATION'))
    exit();
/**
 * Basic Pages - An application for Garden & Vanilla Forums.
 * Copyright (C) 2013  Shadowdare
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

$Session = Gdn::Session();

$Page = $this->Data('Page');

// Format Body
if ((int)$Page->RawBody === 0)
    $FormatBody = Gdn_Format::To($Page->Body, $Page->Format);
else {
    $FormatBody = preg_replace("/(\015\012)|(\015)|(\012)/", "<br />", $Page->Body);
    $FormatBody = FixNl2Br($FormatBody);
}
?>
<div id="Page_<?php echo $Page->PageID; ?>" class="PageContent Page-<?php echo $Page->UrlCode; ?>">
    <?php $this->FireEvent('BeforePageOptions'); ?>
    <?php if ($Session->CheckPermission('Garden.Settings.Manage')): ?>
        <div class="Options">
         <span class="ToggleFlyout OptionsMenu">
            <span class="OptionsTitle" title="<?php echo T('Options'); ?>"><?php echo T('Options'); ?></span>
             <?php echo Sprite('SpFlyoutHandle', 'Arrow'); ?>
             <ul class="Flyout MenuItems" style="display: none;">
                 <?php echo Wrap(Anchor(T('BasicPages.Settings.EditPage', 'Edit Page'),
                     'pagessettings/editpage/' . $Page->PageID, 'EditPage'), 'li'); ?>
             </ul>
         </span>
        </div>
    <?php endif; ?>
    <h1 id="PageTitle" class="H"><?php echo $Page->Name; ?></h1>
    <?php $this->FireEvent('AfterPageTitle'); ?>
    <div id="PageBody"><?php echo $FormatBody; ?></div>
    <?php $this->FireEvent('AfterPageBody'); ?>
</div>
