<?php
/**
ForceFixedIn
Copyright 2010, Brian Enigma <brian@netninja.com>, http://netninja.com
$Id: ForceFixedIn.php 135 2010-03-06 18:47:25Z briane $

ForceFixedIn is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

ForceFixedIn is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

*/

/**
 * requires version_api
 */
require_once( 'version_api.php' );
class ForceFixedInPlugin extends MantisPlugin 
{
 
    function register() 
    {
        $this->name        = 'Force Fixed-In Version';
        $this->description = 'Marking a bug as resolved requires a Fixed-In version, if versions are available.';
        $this->version     = '1.0';
        $this->author      = 'Brian Enigma';
        $this->contact     = 'brian@netninja.com';
        $this->url         = 'http://netninja.com';
    }
 
    function init() 
    {
        plugin_event_hook( 'EVENT_UPDATE_BUG', 'checkUpdate' );
    }
 
    /**
     * Handle bug update
     */
    function checkUpdate($eventName, $bug) 
    {
        // If not Resolved/Fixed, we don't need to block anything. Chain next plugin.
        if (($bug->status != RESOLVED) || ($bug->resolution != FIXED))
            return $bug;
        // Check if version is blank. Succeed (chain next plugin) if filled in.
        if (strlen($bug->fixed_in_version) > 0)
            return $bug;
        // Check if versions are available for the project containing this bug.
        // If no versions availabe, we can't very well expect the user to have
        // filled in a version.
        $versionList = version_get_all_rows($bug->project_id);
        if (sizeof($versionList) == 0)
            return $bug;
        // Assertion: if we reached this line of code, the bug is marked as resolved,
        // fixed, has no fixed in version, but one or more versions exist for the
        // project.  Abort the update!
        $this->raiseError();
    }

    function raiseError()
    {
        // This is probably not the intention of ERROR_VERSION_NOT_FOUND, but it
        // works for our purposes of aborting the update.
        error_parameters("****Version must be entered for resolved+fixed issues****");
		trigger_error(ERROR_VERSION_NOT_FOUND, ERROR);
    }
}
?>
