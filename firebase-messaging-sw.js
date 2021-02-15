/*
*
*  Push Notifications codelab
*  Copyright 2015 Google Inc. All rights reserved.
*
*  Licensed under the Apache License, Version 2.0 (the "License");
*  you may not use this file except in compliance with the License.
*  You may obtain a copy of the License at
*
*      https://www.apache.org/licenses/LICENSE-2.0
*
*  Unless required by applicable law or agreed to in writing, software
*  distributed under the License is distributed on an "AS IS" BASIS,
*  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
*  See the License for the specific language governing permissions and
*  limitations under the License
*
*/

/* eslint-env browser, serviceworker, es6 */

'use strict';

	
self.addEventListener('push', function(event) {
  console.log(`[Service Worker] Push had this data: "${event.data.text()}"`);
	
Notification = JSON.parse(event.data.text());
	console.log(Notification);

	var click_action = Notification.data.link;

  const title = Notification.notification.title;
  const options = {
    body: Notification.notification.body,
    icon: 'images/icon.png',
    badge: 'images/badge.png',
	  data: {
        click_action
      }
  };

  event.waitUntil(self.registration.showNotification(title, options));
});


self.addEventListener('notificationclick', function(event) {
  var redirect_url = event.notification.data.click_action;
  event.notification.close();
  event.waitUntil(
    clients
      .matchAll({
        type: "window"
      })
      .then(function(clientList) {
        console.log(clientList);
        for (var i = 0; i < clientList.length; i++) {
          var client = clientList[i];
          if (client.url === "/" && "focus" in client) {
            return client.focus();
          }
        }
        if (clients.openWindow) {
          return clients.openWindow(redirect_url);
        }
      })
  );
});
