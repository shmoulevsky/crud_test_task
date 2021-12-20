FROM postgres:13.1-alpine
USER postgres
COPY ./postgresql.conf /etc/postgresql/postgresql.conf
CMD ["postgres","-c","config_file=/etc/postgresql/postgresql.conf"]
