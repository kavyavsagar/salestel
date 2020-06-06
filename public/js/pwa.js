const divInstall = document.querySelector('#installContainer');
const buttonInstall = document.querySelector('#btnInstall');

let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
  console.log('👍', 'beforeinstallprompt', event);
  // Prevent the mini-infobar from appearing on mobile
  e.preventDefault();
  // Stash the event so it can be triggered later.
  deferredPrompt = e;
  //window.deferredPrompt = e;
  // Update UI notify the user they can install the PWA
  showInstallPromotion();
});

function showInstallPromotion(){  
  // Remove the 'hidden' class from the install button container
  divInstall.classList.toggle('d-none', false);
}

buttonInstall.addEventListener('click', (e) => {
  console.log('👍', 'butInstall-clicked');
  // Hide the app provided install promotion
  hideMyInstallPromotion();

  //const promptEvent = window.deferredPrompt;
  if (!deferredPrompt) {
    // The deferred prompt isn't available.
    return;
  }
  // Show the install prompt
  deferredPrompt.prompt();
  // Wait for the user to respond to the prompt
  promptEvent.userChoice.then((choiceResult) => {
    console.log('👍', 'userChoice', choiceResult);
    if (choiceResult.outcome === 'accepted') {
      console.log('User accepted the install prompt');
    } else {
      console.log('User dismissed the install prompt');
    }
    // Reset the deferred prompt variable, since
    // prompt() can only be called once.
    deferredPrompt = null;
  })

});

function hideMyInstallPromotion(){
  divInstall.classList.toggle('d-none', true);
}

window.addEventListener('appinstalled', (event) => {
  console.log('👍', 'appinstalled', event);
});
