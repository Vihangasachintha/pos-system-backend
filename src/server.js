require('dotenv').config();

const app  = require('./app');

const PORT = process.env.PORT || 5000;

app.listen(PORT, () => {
  console.log('─────────────────────────────────────');
  console.log(`  POS Server running`);
  console.log(`  Local:   http://localhost:${PORT}`);
  console.log(`  Mode:    ${process.env.NODE_ENV}`);
  console.log('─────────────────────────────────────');
});