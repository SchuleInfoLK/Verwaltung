async function loadDWDData() {
  const apiUrl = 'https://dwd.api.proxy.bund.dev/v30/stationOverviewExtended?stationIds=1423,02559';

  try {
    // API-Daten abrufen
    const response = await fetch(apiUrl);
    if (!response.ok) throw new Error(`Fehler beim Abrufen der API: ${response.statusText}`);

    const data = await response.json();
    console.log('Erfolgreich geladene Daten:', data);
    return data; // Die geladenen Daten werden zurückgegeben
  } catch (error) {
    console.error('Fehler beim Laden der Daten:', error);
    throw error; // Fehler weitergeben, um es beim Aufruf zu behandeln
  }
}

// Beispielaufruf der Funktion
loadDWDData()
  .then(data => {
    // Mit den geladenen Daten arbeiten
    console.log('DWD API-Daten:', data);
  })
  .catch(error => {
    // Fehlerbehandlung
    console.error('API konnte nicht geladen werden:', error);
  });