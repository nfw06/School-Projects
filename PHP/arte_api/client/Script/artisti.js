const SERVER = "http://localhost/php/arte_api/server/";

async function carica_artisti() {
  const risposta = await fetch(`${SERVER}/artisti`);
  const artisti = await risposta.json();
  const corpo_tabella = document.getElementById("corpo-tabella");

  artisti.forEach(artista => {
    const riga = document.createElement("tr");
    riga.innerHTML = `
      <td>${artista.AR_CodiceArtista}</td>
      <td>${artista.AR_Nome}</td>
      <td>${artista.AR_Alias}</td>
      <td>${artista.AR_DataNascita}</td>
      <td>${artista.AR_DataMorte}</td>
      <td>
        <a href="opere_artista.html?id=${artista.AR_CodiceArtista}">Opere</a>
        <a href="modifica_artista.html?id=${artista.AR_CodiceArtista}">Modifica</a>
        <a href="#" onclick="elimina_artista('${artista.AR_CodiceArtista}')">Elimina</a>
      </td>
    `;
    corpo_tabella.appendChild(riga);
  });
}

async function elimina_artista(id) {
  if (!confirm(`Sei Sicuro di Voler Eliminare Artista con id: ${id}?`)) return;
  const risposta = await fetch(`${SERVER}/artisti/${id}`, {
    method: "DELETE"
  });

  const dati = await risposta.json();
  alert(dati.messaggio || dati.errore);

  document.getElementById("corpo-tabella").innerHTML = "";
  carica_artisti();
}

carica_artisti();
