-- ══════════════════════════════════════════════════════════════════════════
-- PRIME LAUNDRY — SQL untuk Supabase Dashboard
-- Jalankan di: Supabase Dashboard → SQL Editor → New Query → Run
-- ══════════════════════════════════════════════════════════════════════════

-- ── 1. Tabel users ──────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.users (
    id               BIGSERIAL PRIMARY KEY,
    name             VARCHAR(100),
    email            VARCHAR(150) UNIQUE NOT NULL,
    password         TEXT,
    phone            VARCHAR(20),
    address          TEXT,
    city             VARCHAR(100),
    zip              VARCHAR(10),
    is_admin         BOOLEAN DEFAULT FALSE,
    membership       VARCHAR(50),
    member_since     DATE,
    member_expiry    DATE,
    social_provider  VARCHAR(30),
    social_id        VARCHAR(200),
    avatar           TEXT,
    remember_token   VARCHAR(100),
    email_verified_at TIMESTAMPTZ,
    created_at       TIMESTAMPTZ DEFAULT NOW(),
    updated_at       TIMESTAMPTZ DEFAULT NOW()
);

-- ── 2. Tabel orders ──────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.orders (
    id               BIGSERIAL PRIMARY KEY,
    code             VARCHAR(20) UNIQUE NOT NULL,
    user_id          BIGINT REFERENCES public.users(id) ON DELETE SET NULL,
    customer         VARCHAR(100) NOT NULL,
    phone            VARCHAR(20),
    address          TEXT,
    service          VARCHAR(80) NOT NULL,
    items            JSONB,
    total            INTEGER DEFAULT 0,
    pickup_date      DATE,
    pickup_time      TIME,
    status           VARCHAR(50) DEFAULT 'still in process',
    payment_status   VARCHAR(20) DEFAULT 'unpaid',
    paid_at          TIMESTAMPTZ,
    date             DATE DEFAULT CURRENT_DATE,
    created_at       TIMESTAMPTZ DEFAULT NOW(),
    updated_at       TIMESTAMPTZ DEFAULT NOW()
);

-- ── 3. Tabel contacts ────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.contacts (
    id         BIGSERIAL PRIMARY KEY,
    nama       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL,
    pesan      TEXT NOT NULL,
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- ── 4. Tabel memberships ─────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS public.memberships (
    id         BIGSERIAL PRIMARY KEY,
    nama       VARCHAR(100) NOT NULL,
    lahir      DATE,
    alamat     TEXT,
    kota       VARCHAR(100),
    kode_pos   VARCHAR(10),
    whatsapp   VARCHAR(20) NOT NULL,
    membership VARCHAR(50),
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- ── 5. Trigger auto-update updated_at ────────────────────────────────────
CREATE OR REPLACE FUNCTION update_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = NOW();
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_users_updated
    BEFORE UPDATE ON public.users
    FOR EACH ROW EXECUTE FUNCTION update_updated_at();

CREATE TRIGGER trg_orders_updated
    BEFORE UPDATE ON public.orders
    FOR EACH ROW EXECUTE FUNCTION update_updated_at();

-- ── 6. Row Level Security (RLS) ───────────────────────────────────────────
-- Aktifkan RLS agar data aman
ALTER TABLE public.users       ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.orders      ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.contacts    ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.memberships ENABLE ROW LEVEL SECURITY;

-- Policy: anon bisa INSERT ke contacts dan memberships (form publik)
CREATE POLICY "Public insert contacts"    ON public.contacts    FOR INSERT TO anon WITH CHECK (true);
CREATE POLICY "Public insert memberships" ON public.memberships FOR INSERT TO anon WITH CHECK (true);

-- Policy: user hanya bisa lihat & ubah data sendiri
CREATE POLICY "User read own orders"  ON public.orders FOR SELECT USING (true);  -- semua bisa cek status
CREATE POLICY "User insert orders"    ON public.orders FOR INSERT TO authenticated WITH CHECK (true);

-- Policy: service_role (Laravel backend) bisa akses semua
CREATE POLICY "Service full access users"       ON public.users       FOR ALL TO service_role USING (true) WITH CHECK (true);
CREATE POLICY "Service full access orders"      ON public.orders      FOR ALL TO service_role USING (true) WITH CHECK (true);
CREATE POLICY "Service full access contacts"    ON public.contacts    FOR ALL TO service_role USING (true) WITH CHECK (true);
CREATE POLICY "Service full access memberships" ON public.memberships FOR ALL TO service_role USING (true) WITH CHECK (true);

-- ── 7. Data dummy admin (opsional, untuk test) ────────────────────────────
INSERT INTO public.users (name, email, password, is_admin)
VALUES ('Admin', 'admin@primelaundry.com', 'hashed_in_laravel', TRUE)
ON CONFLICT (email) DO NOTHING;

-- ── 8. Index untuk performa ───────────────────────────────────────────────
CREATE INDEX IF NOT EXISTS idx_orders_code        ON public.orders(code);
CREATE INDEX IF NOT EXISTS idx_orders_user_id     ON public.orders(user_id);
CREATE INDEX IF NOT EXISTS idx_orders_date        ON public.orders(date);
CREATE INDEX IF NOT EXISTS idx_orders_pay_status  ON public.orders(payment_status);
CREATE INDEX IF NOT EXISTS idx_users_email        ON public.users(email);
