function getProducts () {
	fetch('https://dwd.api.proxy.bund.dev/v30/stationOverviewExtended?stationIds=1423,02559')//https://dummyjson.com/products
		.then(res => res.json())
		.then(console.log);
}
getProducts();

const stationDiv = document.getElementById("output");
jsonData = "Fehler"
stationDiv.innerHTML = ""
stationDiv.innerHTML = `<p> Output: ${jsonData} </p>`
console.log(jsonData);