<?PHP /* $Id$ */
# This file is part of Chatty :)
# Copyright (C) 2003, 2004, 2005 Marco Olivo
#
# Chatty :) is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

include("config.inc.php");
include("lang.inc.php");

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\r\n";

echo "<HTML>\r\n";
echo "<HEAD>\r\n";
echo "<LINK REL=\"stylesheet\" HREF=\"style.css.php\" TYPE=\"text/css\">\r\n";
echo "</HEAD>\r\n\r\n";

echo "<BODY CLASS=\"logo\">\r\n";
echo "<DIV CLASS=\"center\">\r\n";
echo "<SPAN CLASS=\"smallwhite\"><A HREF=\"http://$your_host/\" target=\"_top\"><IMG SRC=\"$logo_url\" ALT=\"$lang[logo_desc]\" BORDER=\"0\"></A></SPAN>\r\n";
echo "</DIV>\r\n";
echo "</BODY>\r\n";
echo "</HTML>\r\n";
?>