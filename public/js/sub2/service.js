export default Object.freeze({
  fetchCurrentExchangeRate () {
    return fetch("/restAPI/currentExchangeRate.php").then( v => v.json());
  }
})