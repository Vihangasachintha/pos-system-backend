const jwt = require('jsonwebtoken');

const generateToken = (user) => {
  const payload = {
    id:   user.id,
    name: user.name,
    role: user.role,   // 'admin' | 'manager' | 'cashier'
  };

  const token = jwt.sign(
    payload,
    process.env.JWT_SECRET,
    { expiresIn: process.env.JWT_EXPIRES_IN }
  );

  return token;
};

module.exports = generateToken;