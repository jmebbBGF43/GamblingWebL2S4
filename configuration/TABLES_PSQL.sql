-- 1. On crée d'abord les types ENUM (une seule fois)
CREATE TYPE user_role AS ENUM ('user', 'admin');
CREATE TYPE bet_status AS ENUM ('win', 'loss', 'pending', 'refunded');

-- 2. Table Users
CREATE TABLE users (
                       id SERIAL PRIMARY KEY,
                       username VARCHAR(50) NOT NULL UNIQUE,
                       password_hash VARCHAR(255) NOT NULL,
                       credits DECIMAL(12, 2) DEFAULT 0.00,
                       role user_role DEFAULT 'user',
                       is_banned BOOLEAN DEFAULT FALSE,
                       can_play BOOLEAN DEFAULT TRUE,
                       can_transact BOOLEAN DEFAULT TRUE,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Table Games
CREATE TABLE games (
                       id SERIAL PRIMARY KEY,
                       slug VARCHAR(50) NOT NULL UNIQUE,
                       name VARCHAR(100) NOT NULL,
                       is_active BOOLEAN DEFAULT TRUE,
                       probabilities JSONB NULL
);

-- 4. Table Bets
CREATE TABLE bets (
                      id BIGSERIAL PRIMARY KEY,
                      user_id INT NOT NULL,
                      game_id INT NOT NULL,
                      bet_amount DECIMAL(12, 2) NOT NULL,
                      payout DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
                      status bet_status DEFAULT 'pending',
                      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                      CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                      CONSTRAINT fk_game FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);