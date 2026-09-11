CREATE TABLE IF NOT EXISTS users
(
    id            VARCHAR(32) PRIMARY KEY,
    email         VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    roles         JSONB        NOT NULL DEFAULT '[
      "ROLE_USER"
    ]'::jsonb,
    created_at    TIMESTAMPTZ  NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMPTZ  NULL
);

CREATE TABLE IF NOT EXISTS audit_logs
(
    id         BIGSERIAL PRIMARY KEY,
    user_id    VARCHAR(32),
    action     VARCHAR(50)  NOT NULL,
    entity     VARCHAR(100) NOT NULL,
    entity_id  VARCHAR(100),
    old_values JSONB,
    new_values JSONB,
    created_at TIMESTAMPTZ  NOT NULL DEFAULT CURRENT_TIMESTAMP
);
