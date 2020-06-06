var CACHE_NAME = 'pwgen-cache-v1';
/**
 * The install event is fired when the registration succeeds.
 * After the install step, the browser tries to activate the service worker.
 * Generally, we cache static resources that allow the website to run offline
 */
self.addEventListener('install', async function () {
    const cache = await caches.open(CACHE_NAME);
    cache.addAll([
    
    ])
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        // Cache hit - return response
        if (response) {
          return response;
        }
        return fetch(event.request);
      }
    )
  );
});

//self.addEventListener('beforeinstallprompt', saveBeforeInstallPromptEvent);

// function saveBeforeInstallPromptEvent(evt) {
//     deferredInstallPrompt = evt;
//     deferredInstallPrompt.prompt();
// }