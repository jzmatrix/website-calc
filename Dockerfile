FROM golang:1.16-alpine

WORKDIR /app

ADD go ./

RUN go mod download

RUN go build -o /website-calc

EXPOSE 80

CMD [ "/website-calc" ]