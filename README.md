# Portfolio [BackOffice]

L'applicazione ha l'obbiettivo di permettere all'utente autenticato di gestire e pubblicare i propri progetti su una vetrina pubblica. E' previsto inoltre il ruolo di Admin per poter gestire i progetti di tutti gli utenti e le altre risorse in modo avanzato.

## Features

#### Autenticazione

- E' possibile registrarsi con il ruolo di utente semplice (user);
- E' possibile autenticarsi ed accedere come utente semplice (user) o amministratore (Admin);
- L'utente semplice (user) potrà gestire solo le proprie risorse e quelle comuni in modo limitato;
- L'utente amministratore (Admin) potrà gestire tutte le risorse in modo avanzato;
- Tutte le risorse sono protette in modo che ogni utente semplice (user) non possa in alcun modo interferire con le risorse di un altro utente.

#### HomePage Pubblica

- La home permette la visualizzazione e la ricerca tramite filtri avanzati anche agli utenti non autenticati;
- I filtri permettono di visualizzare i progetti in base all'autore, la categoria e le tecnologie utilizzate;
- i filtri sono soggetti a validazione.

#### Progetti

- E' possibile creare, visualizzare, modificare ed eliminare i propri progetti; (user)
- E' possibile creare, visualizzare, modificare ed eliminare qualsiasi progetto; (Admin)
- Ad ogni progetto è possibile assegnare un'immagine, una categoria e una o più tecnologie. (user/Admin)

#### Categorie

- E' possibile visualizzare tutte categorie; (user/Admin)
- E' possibile creare, modificare ed eliminare categorie; (Admin)
- Ad ogni categoria è possibile assegnare un colore per una visualizzazione più efficacie. (Admin)

#### Tecnologie

- E' possibile visualizzare tutte tecnologie; (user/Admin)
- E' possibile creare, modificare ed eliminare tecnologie; (Admin)
- Ad ogni categoria è possibile assegnare un colore per una visualizzazione più efficacie. (Admin)

#### API REST

- API per il recupero dei progetti paginati;
- API per il recupero del singolo progetto;
- API per il recupero di tutte le categorie paginate;
- API per il recupero di tutte le tecnologie paginate.

#### Paginazione

- Dove necessario, i risultati vengono paginati per prevenire lunghe attese ed consentire una migliore visualizzazione

#### Validazione

- Tutti i form vangono validati in modo da guidare l'utente;
- La validazione permette di prevenire inutili chiamate al server migliorando la velocità di risposta e prevenendo errori dovuti al sovraccarico di chiamate.

#### Conferma operazioni

- Ogni operazione di modifica delicata (come l'eliminazione), prevede la richiesta di conferma dell'utente.
- All'eliminazione di una specifica categoria, sarà possibile decidere se i progetti ad essa associata dovranno essere eliminati o assegnati ad una nuova categoria.

## Next Features

- E' in via di sviluppo l'invio di mail automatiche alla creazione e alla modifica di un progetto;
- E' in via di sviluppo il mantenimento dei dati a sistema anche dopo l'eliminazione e il loro ripristino;

## Tecnologie utilizzate

-   BackEnd in PHP 8.1 con framework <b>[Laravel 9.x](https://laravel.com/)</b> e DB <b>MySQL</b>
-   Styling in <b>[SASS SCSS](https://sass-lang.com/)</b> e framework <b>[Boostrap5](https://getbootstrap.com/)</b>
-   Precompilazione tramite <b>[Vite](https://vitejs.dev/)</b>
-   Icone tramite pacchetti <b>[Fontawesome](https://fontawesome.com/)</b>

## Inizializzare il progetto

-   Creare il file `.env` a partire dal file `.env.example`;
-   Eseguire il comando `composer i` per installare le dipendenze composer;
-   Eseguire il comando `php artisan key:generate` per generare l'APP_KEY;
-   Eseguire il comando `npm i` per installare le dipendenze NPM;
-   Eseguire il comando `php artisan serve` per eseguire l'app in locale;
-   Eseguire il comando `npm run dev` per eseguire il frontend in locale;
