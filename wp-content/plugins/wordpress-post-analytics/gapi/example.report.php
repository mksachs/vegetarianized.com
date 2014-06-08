<?php

require_once('../../../../wp-load.php');

define('ga_email',get_option('email_id'));
define('ga_password',get_option('ga-pass'));
define('ga_profile_id',get_option('profile_id'));

require 'gapi.class.php';
$quer=$_GET["q"];
$ga = new gapi(ga_email,ga_password);
$filter = 'pagePath=='.$quer;

$ga->requestReportData(ga_profile_id,array('hostname','pagePath'),array('uniquePageviews','visits','timeOnPage'),'-visits',$filter);

?>
<table>
<tr>
  <th>Page URL</th>
  <th>Pageviews</th>
  <th>Visits</th>
  <th>Time On Page</th>
</tr>
<?php
foreach($ga->getResults() as $result):
?>
<tr>
  <td><?php echo $result ?></td>
  <td><center><?php echo $result->getuniquePageviews() ?></center></td>
  <td><center><?php echo $result->getVisits() ?></center></td>
   <td><center><?php echo $result->gettimeOnPage() ?></center></td>
</tr>
<?php
endforeach
?>
</table>

