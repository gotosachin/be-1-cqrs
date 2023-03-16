FROM nginx:1.20

RUN apt-get update -yqq \
    && apt-get install -yqq --no-install-recommends \
    nginx-extras \
    && apt-get remove -qq --purge -y $BUILD_PACKAGES \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
