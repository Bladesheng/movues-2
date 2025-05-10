# MoVues 2

This website shows you which new movies and TV shows are currently airing or about to be released.
You
can also view detailed information for each title.

Most of the data is fetched from TMDB API and some data is also scraped from CSDF using
my [cloudflare worker proxy](https://github.com/Bladesheng/csfd-api-proxy).

This is continuation of my previous project: [new-movues](https://github.com/Bladesheng/new-movues).

Technical details:

- Backend: Laravel
- Frontend: Vue + Inertia, Tailwind, daisyUI
  - I built this mainly to try out fullstack Laravel with Vue
- New movies and TV shows are fetched from TMDB API once a day and are saved to database
  - Unlike the old app, users don't have to make hundreds of requests to TMBD, or provide their
    own API key
- Anything older than 90 days is automatically deleted
- Details of a movie are fetched from TMDB only when needed and are cached
  - Same goes for CSFD details
- The list of movies is properly paginated so browser's back/forward navigation actually works this
  time
