const fs = require('fs');

console.log('Inizio');

fs.readFile("../ciao.txt", 'utf8', function (errore, data) {
  if (errore) {
    console.log(errore);
    process.exit(1);
  } else {
    console.log(data);
  }
});

console.log('Fine');