# Laravel - LV3_4

## Opis
Web aplikacija za upravljanje projektima

## Funkcionalnosti

### Projekti
- **Kreiranje projekta**: Korisnik može kreirati novi projekt s nazivom, opisom i datumima
- **Pregled projekata**: 
  - Lista projekata gdje je korisnik voditelj
  - Lista projekata gdje je korisnik član tima
- **Uređivanje projekta**:
  - **Voditelj**: Može mijenjati sve podatke, dodavati/uklanjati članove tima, uređivati zadatke
  - **Član tima**: Može samo uređivati obavljene zadatke
- **Automatsko dodavanje**: Voditelj projekta automatski postaje i član tima

### Tablica: `projects`
- `id` - primarni ključ
- `user_id` - strani ključ (voditelj projekta)
- `naziv` - naziv projekta
- `opis` - opis projekta
- `obavljeni_poslovi` - evidencija obavljenih poslova
- `datum_pocetka` - datum početka projekta
- `datum_zavrsetka` - datum završetka projekta
- `created_at`, `updated_at` - timestampovi

## Pokretanje

Pokreni development servere
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm install
npm run dev
```

## Putanje

1. Registracija -> `/register`
2. Prijava -> `/login`
3. Popis projekata -> `/projects`