# Description
PrestaShop module that enables removing order payments \
Tested with PrestaShop 8 and PHP 8.1

# Install
This installs as a standard PrestaShop module. You can get the latest version from [Releases](https://github.com/andreihumulescu/ps-remove-order-payment/releases) \
Upload the archive to Admin -> Module Manager

# Usage
Once the module has been successfully installed, a 'Remove' button will be displayed for each order payment as shown below \
![image](screenshots/remove_button.png)
If you click on the 'Remove' button, a confirn popup will be displayed. \
Once the action has been confirmed, a request for deleting the payment will be sent. \
Based on the outcome of the request, another popup message will be displayed. \
If the payment was deleted, once the popup is confirmed, the page will be refreshed. At this point, the payment should not be displayed under the 'Payment' tab anymore.
