const express = require('express');
const cors    = require('cors');
const morgan  = require('morgan');

const app = express();

// ─── Middleware ───────────────────────────────────────────────
app.use(cors());                         // Allow cross-origin requests
app.use(express.json());                 // Parse JSON request bodies
app.use(express.urlencoded({ extended: true })); // Parse form data
app.use(morgan('dev'));                  // Log every request in terminal

// ─── Routes ──────────────────────────────────────────────────

// Health check — open http://localhost:5000/ to confirm server is up
app.get('/', (req, res) => {
  res.json({
    success: true,
    message: 'POS Server is running',
    version: '1.0.0',
  });
});

// ── Auth ──────────────────────────────────────────────────────
app.post('/api/auth/login', (req, res) => {
  res.json({ success: true, message: 'Login route — coming soon' });
});

app.post('/api/auth/logout', (req, res) => {
  res.json({ success: true, message: 'Logout route — coming soon' });
});

// ── Products ──────────────────────────────────────────────────
app.get('/api/products', (req, res) => {
  res.json({ success: true, data: [], message: 'Products list — coming soon' });
});

app.get('/api/products/:id', (req, res) => {
  res.json({ success: true, data: {}, message: `Product ${req.params.id} — coming soon` });
});

app.post('/api/products', (req, res) => {
  res.json({ success: true, message: 'Create product — coming soon' });
});

app.put('/api/products/:id', (req, res) => {
  res.json({ success: true, message: `Update product ${req.params.id} — coming soon` });
});

app.delete('/api/products/:id', (req, res) => {
  res.json({ success: true, message: `Delete product ${req.params.id} — coming soon` });
});

// ── Sales ─────────────────────────────────────────────────────
app.post('/api/sales', (req, res) => {
  res.json({ success: true, message: 'Create sale — coming soon' });
});

app.get('/api/sales', (req, res) => {
  res.json({ success: true, data: [], message: 'Sales list — coming soon' });
});

app.get('/api/sales/:id', (req, res) => {
  res.json({ success: true, data: {}, message: `Sale ${req.params.id} — coming soon` });
});

// ── Inventory ─────────────────────────────────────────────────
app.get('/api/inventory', (req, res) => {
  res.json({ success: true, data: [], message: 'Inventory — coming soon' });
});

app.post('/api/inventory/adjust', (req, res) => {
  res.json({ success: true, message: 'Stock adjust — coming soon' });
});

// ── Reports ───────────────────────────────────────────────────
app.get('/api/reports/daily', (req, res) => {
  res.json({ success: true, data: {}, message: 'Daily report — coming soon' });
});

app.get('/api/reports/monthly', (req, res) => {
  res.json({ success: true, data: {}, message: 'Monthly report — coming soon' });
});

// ─── 404 Handler ──────────────────────────────────────────────
app.use((req, res) => {
  res.status(404).json({
    success: false,
    message: `Route not found: ${req.method} ${req.originalUrl}`,
  });
});

// ─── Global Error Handler ─────────────────────────────────────
app.use((err, req, res, next) => {
  console.error('Server Error:', err.message);
  res.status(500).json({
    success: false,
    message: 'Internal server error',
    error: process.env.NODE_ENV === 'development' ? err.message : undefined,
  });
});

module.exports = app;