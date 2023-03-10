function hideelement($param) {
	$(".feed_" + $param).hide();
	$(".share_" + $param).hide();
}


function bookmark($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".bookmark_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".bookmark_" + $param).hide();
		$(".unbookmark_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function unbookmark($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".unbookmark_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".unbookmark_" + $param).hide();
		$(".bookmark_" +  + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function subscribe($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".subscribe_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".subscribe_" + $param).hide();
		$(".suggestion_" + $param).hide();
		$(".unsubscribe_" + $param).show();
		$(".unsubscribe_" + $param).children("input[name='sub_id']").val(''+response+'');
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function unsubscribe($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".unsubscribe_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".unsubscribe_" + $param).hide();	
		$(".subscribe_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function unsubscribe($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".unsubscribe_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".unsubscribe_" + $param).hide();
		$(".subscribe_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function unshare($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".unshare_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".unshare_" + $param).hide();
		$(".share_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function autoshare_on($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".autoshare_on_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".autoshare_on_" + $param).hide();
		$(".autoshare_off_" + $param).show();
		$(".sharing_options_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function autoshare_off($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".autoshare_off_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".autoshare_off_" + $param).hide();
		$(".sharing_options_" + $param).hide();
		$(".autoshare_on_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function sharetitle_on($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".sharetitle_on_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".sharetitle_on_" + $param).hide();
		$(".sharetitle_off_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function sharetitle_off($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".sharetitle_off_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".sharetitle_off_" + $param).hide();
		$(".sharetitle_on_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function sharedescription_on($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".sharedescription_on_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".sharedescription_on_" + $param).hide();
		$(".sharedescription_off_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function sharedescription_off($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".sharedescription_off_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".sharedescription_off_" + $param).hide();
		$(".sharedescription_on_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function shareimage_on($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".shareimage_on_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".shareimage_on_" + $param).hide();
		$(".shareimage_off_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function shareimage_off($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".shareimage_off_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".shareimage_off_" + $param).hide();
		$(".shareimage_on_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function is_sensitive_on($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".is_sensitive_on_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".is_sensitive_on_" + $param).hide();
		$(".is_sensitive_off_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function is_sensitive_off($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".is_sensitive_off_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".is_sensitive_off_" + $param).hide();
		$(".is_sensitive_on_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function sensitive_text($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".sensitive_text_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".sensitive_button_on_" + $param).hide();
		$(".sensitive_button_off_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function set_visibility($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".visibility_" + $param).change(function (event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function telegram_on($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".telegram_on_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".telegram_on_" + $param).hide();
		$(".telegram_off_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function telegram_off($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".telegram_off_" + $param).submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".telegram_off_" + $param).hide();
		$(".telegram_on_" + $param).show();
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}



function publish() {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".publish").submit(function(event){

	// Prevent default posting of form - put here to work in case of errors
	event.preventDefault();

	// Abort any pending request
	if (request) {
		request.abort();
	}
	// setup some local variables
	var $form = $(this);

	// Let's select and cache all the fields
	var $inputs = $form.find("input, select, button, textarea");

	// Serialize the data in the form
	var serializedData = $form.serialize();

	// Let's disable the inputs for the duration of the Ajax request.
	// Note: we disable elements AFTER the form data has been serialized.
	// Disabled form elements will not be serialized.
	$inputs.prop("disabled", true);

	// Fire off the request to /form.php
	request = $.ajax({
		url: website + "/includes/action.php",
		type: "post",
		data: serializedData
	});

	// Callback handler that will be called on success
	request.done(function (response, textStatus, jqXHR){
		// Log a message to the console
		$(".publish_button").hide();
		$(".publish_area").val("");
		$(".publish_button_sent").show();
		setTimeout(function(){
    	$(".publish_button").show();
    	$(".publish_button_sent").hide();
		}, 3000);
	});

	// Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		// Log the error to the console
		console.error(
			"The following error occurred: "+
			textStatus, errorThrown
		);
	});

	// Callback handler that will be called regardless
	// if the request failed or succeeded
	request.always(function () {
		// Reenable the inputs
		$inputs.prop("disabled", false);
	});

});
}


function counter(val) {
  var len = val.value.length;
  if (len >= 500) {
    val.value = val.value.substring(0, 500);
  } else {
    $('.counter').text(500 - len);
  }
};


function counter_share(val) {
  var len = val.value.length;
  if (len >= 460) {
    val.value = val.value.substring(0, 460);
  } else {
    $('.counter').text(460 - len);
  }
};


function share($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".share_" + $param).submit(function(event){

    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    // Abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = $(this);

    // Let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");

    // Serialize the data in the form
    var serializedData = $form.serialize();

    // Fire off the request to /form.php
    request = $.ajax({
        url: website + "/includes/share.php",
        type: "POST",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (data, response, textStatus, jqXHR){
        // Log a message to the console
        $(".publish_popup").empty();
        $(".publish_popup").append(data);
        $(".publish_popup").show();
        $('html, body').css({overflow: 'hidden'});
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

});
}


function share2($param) {
// Variable to hold request
var request;
var website = window.location.origin;

// Bind to the submit event of our form
$(".share_button").hide();
$(".shared_button").show();
$(".share_content_" + $param).submit(function(event){

    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    // Abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = $(this);

    // Let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");

    // Serialize the data in the form
    var serializedData = $form.serialize();

    // Fire off the request to /form.php
    request = $.ajax({
        url: website + "/includes/action.php",
        type: "POST",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        $(".share_" + $param).hide();
        $(".unshare_" + $param).show();
        $(".unshare_" + $param).children("input[name='status_id']").val(''+response+'');
        $(".publish_popup").hide();
        $(".publish_popup").empty();
        $('html, body').css({overflow: ''});
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

});
}



function hide_publish(back_url) {
		var back = back_url;
        $(".publish_popup").hide();
        $(".publish_popup").empty();
        $('html, body').css({overflow: ''});
        window.history.pushState("data", "Title", back);
        Amplitude.stop();
}



function story(media_id){
  var website = window.location.origin;
  var new_url = "/story/" + media_id;
  var url = window.location.href;
  $.ajax({
      url: website + '/includes/stories.php?media=' + media_id,
      type: "GET",
      beforeSend: function(){
          $('.ajax-load').show();
          $(".publish_popup").empty();
      }
  }).done(function(data){
      $('.ajax-load').hide();
      $(".publish_popup").append(data);
      window.history.pushState("data", "Title", new_url);
      $(".publish_popup").show();
      $('html, body').css({overflow: 'hidden'});
  }).fail(function(jqXHR, ajaxOptions, thrownError){

  });
}



function podcast(id){
  var website = window.location.origin;
  var new_url = "/podcast/" + id;
  var url = window.location.href;
  $.ajax({
      url: website + '/includes/podcast.php?id=' + id,
      type: "GET",
      beforeSend: function(){
          $('.ajax-load').show();
          $(".publish_popup").empty();
      }
  }).done(function(data){
      $('.ajax-load').hide();
      $(".publish_popup").append(data);
      window.history.pushState("data", "Title", new_url);
      $(".publish_popup").show();
      $('html, body').css({overflow: 'hidden'});
  }).fail(function(jqXHR, ajaxOptions, thrownError){

  });
}



function dark_mode() {
$('#theme').attr('href', '/assets/colors-dark.css');
$('.light_mode').show();
$('.dark_mode').hide();
document.cookie = "theme=dark; path=/; max-age=" + 30*24*60*60;
}

function light_mode() {
$('#theme').attr('href', '/assets/colors-light.css');
$('.light_mode').hide();
$('.dark_mode').show();
document.cookie = "theme=light; path=/; max-age=" + 30*24*60*60;
$(".video_cinema").hide();
}