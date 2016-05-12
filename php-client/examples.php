<?php

require('webcronAPI.php');

// Create instance and set your API login and password 
// These can be found at: https://webcron.org/index.php?option=com_webcron&controller=dashboard&task=api_key
$api = new webcronAPI('apiLoginCode','apiPassword');

// Enable debug for more information on what's happening
$api->debug = true;




// INFO METHOD
// first invoke the 'info' method for info on your account.
$xml = $api->call('info');

// Use SimpleXML for easy parsing of the returned xml, or use your own parser...
$data = new SimpleXMLElement($xml);

// Get the returned status
$status = $data->attributes()->status;

echo "Status of info call is: $status <br>";
echo "Returned data can be found in the SimpleXML object:<br>";
print_r($data);
echo '<hr>';






// ADD CRON METHOD
// Now, lets add a cron to your account
// First we set all the required parameters in an array
// The exec_delay can be used to set a cron to launch ones. 
// In this example it will launch in 12 minutes.
$cron = array(
	'name' => 'my first cron',
	'url' => 'http://your.url.com/script.php?parameter=first&otherparam=second',
	'exec_delay' => 12);

// Execute the cron.add method
$xml2 = $api->call('cron.add',$cron);

// Use SimpleXML for easy parsing of the returned xml, or use your own parser...
$data2 = new SimpleXMLElement($xml2);

// Get the returned status. If the status is "ok", you will find your cron in 
// the green group called "One-off cronjobs" on the webcron dashboard page
$status2 = $data2->attributes()->status;

echo "Status of cron.add call is: $status2 <br>";
echo "Returned data can be found in the SimpleXML object:<br>";
print_r($data2);
echo '<hr>';





// BIND CONTACT METHOD
// Now, I want to receive a notification when this job is launched
// Make sure you have created at least one contact on your Webcron dashboard page
// we use the id of the cron we created previously, and set alert_type to 'a' (= always send notification)
$cron_contact = array(
	'contact_name' => 'myContactName',
	'cron_id' => $data2->cron->attributes()->id,
	'alert_type' => 'a');

// Execute the cron.add method
$xml3 = $api->call('cron.contact.bind',$cron_contact);

// Use SimpleXML for easy parsing of the returned xml, or use your own parser...
$data3 = new SimpleXMLElement($xml3);

// Get the returned status. If the status is "ok", you will find your contact 
// attached to the one-off cron you created before in 
$status3 = $data3->attributes()->status;

echo "Status of cron.contact.bind call is: $status3 <br>";
echo "Returned data can be found in the SimpleXML object:<br>";
print_r($data3);
echo '<hr>';





// ADD MONITOR METHOD
// Now, lets add a server you want to have monitored to your account
// First we set all the required parameters in an array
$monitor = array(
	'name' => 'myMonitorName',
	'protocol' => 'http',
	'url' => 'http://your.url.com/',
	'frequence' => 1);

// Execute the cron.add method
$xml_monitor = $api->call('monitor.add',$monitor);

// Use SimpleXML for easy parsing of the returned xml, or use your own parser...
$data_monitor = new SimpleXMLElement($xml_monitor);

// Get the returned status. If the status is "ok", you will find your cron in 
// the green group called "One-off cronjobs" on the webcron dashboard page
$status_monitor = $data_monitor->attributes()->status;

echo "Status of monitor.add call is: $status_monitor <br>";
echo "Returned data can be found in the SimpleXML object:<br>";
print_r($data_monitor);
echo '<hr>';



// All API methods with description can be found at http://www.webcron.org/api-reference
// For questions, send us a message: http://www.webcron.org/contact
?>
