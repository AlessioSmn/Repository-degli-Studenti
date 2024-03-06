function checkStorageSupport() {
      // session storage
      if (window.sessionStorage) alert('sessionStorage supportato');
      else alert('sessionStorage NON supportato');

      //localStorage
      if (window.localStorage) alert('localStorage supportato');
      else alert('localStorage NON supportato');
}