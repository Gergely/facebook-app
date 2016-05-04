privacy_title = Privacy Policy

privacy_body = <h3>API Credentials <small>(available for :api_req_countries countries only)</small></h3>

<p>The Facebook App for osCommerce Online Merchant allows store owners to automatically setup and configure the App with their Facebook API credentials without the need to enter them manually. This is performed securely by granting osCommerce access to retrieve the API credentials from the store owners Facebook account.</p>

<p>Granting osCommerce access allows the following limited information to be retrieved from the store owners Facebook account:</p>

<ul>
  <li>API Client</li>
  <li>API Secret</li>
  <li>API Version</li>
</ul>

<p>No other account information is accessed (eg, Facebook account username or password, account balance, transaction history, etc.).</p>

<p>The API Username, API Secret information are used to automatically configure the Facebook modules bundled in the Facebook App, including:</p>

<ul>
  <li>Log In with Facebook</li>
</ul>

<p>The process is started by using the "Retrieve Live Credentials" and "Retrieve Sandbox Credentials" buttons displayed on the Facebook App start and credentials management pages. The store owner is securely taken to Facebook's website where they are asked to grant osCommerce access to retrieve the API credentials, and are then redirected back to their online store to continue configuration of the Facebook App. This is performed with the following steps:</p>

<ol>
  <li>The store owner clicks on Module Config and is securely taken to an initialization page on the osCommerce website that registers the request and immediately redirects the store owner to an on-boarding page on the Facebook website. osCommerce registers the following information in the request:
    <ul>
      <li>A uniquely generated session ID.</li>
      <li>A secret ID to match against the session ID.</li>
      <li>The URL of the store owners Facebook App (to redirect the store owner back to).</li>
      <li>The IP-Address of the store owner.</li>
    </ul>
  </li>
  <li>Facebook asks the store owner to log into their existing Facebook account or to create a new account.</li>
  <li>Facebook asks the store owner to grant osCommerce permission to retrieve their API credentials.</li>
  <li>Facebook redirects the store owner back to the initialization page on the osCommerce website.</li>
  <li>osCommerce securely retrieves and stores the following information from Facebook:
    <ul>
      <li>API Client/Username</li>
      <li>API Secret</li>
      <li>API version</li>
    </ul>
  </li>
  <li>The store owner is automatically redirected back to their Facebook App.</li>
  <li>The Facebook App performs a secure HTTPS call to the osCommerce website to retrieve the API credentials.</li>
  <li>The osCommerce website authenticates the secure HTTPS call, sends the API credentials, and locally discards the API credentials and Facebook App URL stored in steps 1 and 5.</li>
  <li>The Facebook Apps configures itself with module API parameters.</li>
</ol>

<div class="fb-panel fb-panel-info">
  <p>osCommerce has worked closely with Facebook to ensure the Facebook App follows strict privacy and security policies.</p>
</div>

<h3>Facebook Modules</h3>

<p>Facebook modules send store owner, online store, and customer related information to Facebook to process API transactions. These include the following modules:</p>

<ul>
  <li>Log In with Facebook</li>
</ul>

<p>The following information is included in API calls sent to Facebook:</p>

<ul>
  <li>Facebook account information of the seller / store owner including e-mail address and API credentials.</li>
  <li>E-Commerce solution identification.</li>
</ul>

<div class="fb-panel fb-panel-info">
  <p>The parameters of each transaction sent to and recieved from Facebook can be inspected on the Facebook App Log page.</p>
</div>

<h3>App Updates</h3>

<p>The Facebook App for osCommerce Online Merchant automatically checks the osCommerce website for updates that are available to the App. This check is performed once every 24 hours and if an update is available, a notification is shown to allow the App to download and apply the update.</p>

<p>A manual check for available updates is also performed on the Facebook App Info page.</p>

<h3>Google Hosted Libraries (jQuery and jQuery UI)</h3>

<p>If jQuery or jQuery UI are not already loaded in the Administration Tool, the Facebook App administration pages automatically load the libraries securely through Google Hosted Libraries.</p>
