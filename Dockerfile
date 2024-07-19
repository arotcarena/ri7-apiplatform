FROM dunglas/frankenphp:latest

# add additional extensions here:
RUN install-php-extensions \
pdo_pgsql \
intl \
zip \
opcache

ARG DEVELOPED_BY=username

# Definition d'une variable d'environnement pour le port
ENV PORT=8080
ENV DEVELOPED_BY=${DEVELOPED_BY:-username}
RUN echo "PORT : ${PORT}"

# Bash
RUN apk add --no-cache bash
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash
RUN apk add symfony-cli

# Définir le répertoire de travail dans le conteneur
WORKDIR /app
# Copier tous les fichiers de l'application dans le répertoire de travail
COPY . .
# Exposer le port 8080 pour accéder à l'application
EXPOSE ${PORT}

RUN symfony composer install

# Définir la commande par défaut pour lancer l'application
CMD symfony serve --port=$PORT --dir=./