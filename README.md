#ForceFixedIn - Version 1.0

Copyright 2010, Brian Enigma, <http://netninja.com/projects/forcefixedin/>

Licensed under the GNU General Public License.

A Mantis bug tracker plugin that enforced the "Fixed In" field be entered

##THEORY

Mantis is a great bug tracking system.  It offers some great control over 
process and workflow, but not quite the granularity that I need.  
Specifically, I work in an environment where it is vital that the "fixed-in"
version is filled in when resolving an issue as "fixed."  Without this, there
is no easy way to generate an accurate changelog.  Although we all do our
best to fill this field in, there are slipups.  To better catch these 
slipups when they occur, I have written the ForceFixedIn plugin.

The plugin itself is relatively simple and follows this pseudocode:

1. Is the issue getting marked as "resolved?"
2. Is the issue getting marked as "fixed?"
3. Does the issue belong to a project for which one or more versions are 
   defined?
4. If all of the above is "yes," then fail unless something has been 
   entered for a fixed-in version number.

##REQUIREMENTS

Mantis 1.2.0 or greater is required.

##INSTALLATION

Installation is simple and involves creating a plugin folder and copying the
plugin's PHP file into the folder.  You then activate it from within Mantis.

1. Create a folder under your mantis plugins folder named ForceFixedIn.
   For instance, if you have Mantis installed at /var/www/mantisbt, then
   you would create /var/www/mantisbt/plugins/ForceFixedIn.
2. Copy ForceFixedIn.php into this folder.
3. Log in to Mantis as an administrator.
4. Go to Manage -> Manage Plugins and click "Install" next to ForceFixedIn.

Have fun!
