// Regionen oder Orte festlegen, für die Warnungen abgerufen werden sollen
const monitoredRegions = ["Berlin", "München", "Hamburg"];

// API-Endpunkt der DWD
const DWD_API_URL = "https://s3.eu-central-1.amazonaws.com/app-prod-static.warnwetter.de/v16/gemeinde_warnings_v2.json";

// Funktion zum Abrufen der Warnungen
async function fetchWarnings() {
  try {
    const response = await fetch(DWD_API_URL);
    if (!response.ok) throw new Error("Fehler beim Abrufen der Warnungen.");
    
    const data = await response.json();
    displayWarnings(data);
  } catch (error) {
    console.error("Fehler:", error);
    document.getElementById("warnungen").innerText = "Warnungen konnten nicht geladen werden.";
  }
}

// Funktion zum Anzeigen der Warnungen
function displayWarnings(data) {
  const warnungenDiv = document.getElementById("warnungen");
  warnungenDiv.innerHTML = "";

  const relevantWarnings = data.warnings.filter(warning => 
    monitoredRegions.some(region => warning.regionName.includes(region))
  );

  if (relevantWarnings.length === 0) {
    warnungenDiv.innerHTML = "<p>Keine aktuellen Warnungen für die ausgewählten Regionen.</p>";
    return;
  }

  relevantWarnings.forEach(warning => {
    const warningDiv = document.createElement("div");
    warningDiv.className = "warnung";

    warningDiv.innerHTML = `
      <h3>${warning.event} - ${warning.regionName}</h3>
      <p><strong>Von:</strong> ${new Date(warning.start).toLocaleString()}</p>
      <p><strong>Bis:</strong> ${new Date(warning.end).toLocaleString()}</p>
      <p>${warning.description}</p>
    `;

    warnungenDiv.appendChild(warningDiv);
  });
}

// Daten beim Laden der Seite abrufen
document.addEventListener("DOMContentLoaded", fetchWarnings);
