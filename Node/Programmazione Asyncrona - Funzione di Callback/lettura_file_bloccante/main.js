const fs = require('fs');

console.log('Inizio');

let file = fs.readFileSync("../ciao.txt", 'utf8');

console.log(file);
console.log('Fine');