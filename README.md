# Xs and Os ![coverage](https://img.shields.io/badge/coverage-71%25-yellowgreen.svg)
##### An attempt to implement turn-based strategy game.

This is the repository of my pet-project which i planned out as a sandbox to explore the possibilities of implementing a turn-based strategic game. The purposes of this project are: studying and applying some techniques and development patterns, confirming my hypothesis, exploring language innovations and the research of technologies. Also, this project is a representation of my developer skills.

This project implements the tic-tac-toe application server, but there are plans to develop a much more complex turn-based strategic game that includes hexagonal fields and robots <img src = "https://assets-cdn.github.com/images/icons/emoji/suspect.png" width = "20" height = "20" >.

The application architecture is based on the principle of command-query separation. This does not mean that the application implements the CQRS pattern, but in the long term it can be included, as well as Event Sourсing.

The application works with Silex framework but is, in general, guided by the CQS principle which is making the architecture framework-agnostic. That would allow changing the framework without much loss.

The application use one relational db (MySQL) as a data storage both for reading and writing, and Doctrine ORM as the database abstraction layer.

For the convenience of development, i used a docker-based environment.

API is built on top of HTTP protocol. In response, the server provides json data which structure inherits the [jsend](https://labs.omniti.com/labs/jsend) specification.

#### API request / response examples

##### Create game request:
```
curl 
    -F "token=2ed58ec5-bd77-4482-a868-ffd4128a4123" 
    -X POST http://127.0.0.1/api/game/create
```

##### response:
```
{
  "status": "success",
  "data": {
    "id": "64395a0d-1fb8-4f54-9f8c-9400d8494e36"
  }
}
```

##### Join a game request:
```
curl 
    -F "token=2ed58ec5-bd77-4482-a868-ffd4128a4123" 
    -X POST http://127.0.0.1/api/game/2ed58ec5-bd77-4482-a868-ffd4128a4123/join
```

##### response:
```
{
  "status": "success",
  "data": null
}
```

##### Make a turn request:
```
curl 
    -F "token=81b18488-b023-4cb0-99e7-b247a4992290" 
    -F "x=1" 
    -F "y=1" 
    -X POST http://127.0.0.1/api/game/c1a78c1c-4b9f-49c2-a4d1-783c5caa6baa/turn
```

##### response:
```
{
  "status": "success",
  "data": null
}
```

##### Get game stats request:
```
curl -X GET http://127.0.0.1/api/game/b29218e9-2a25-4290-89b4-74bba378d3fa
```

##### response:
```
{
  "status": "success",
  "data": {
    "game": {
      "id": "b29218e9-2a25-4290-89b4-74bba378d3fa",
      "players": [
        "2ed58ec5-bd77-4482-a868-ffd4128a4123",
        "81b18488-b023-4cb0-99e7-b247a4992290"
      ],
      "board": [[1,0,0],[0,1,0],[0,0,2]],
      "winner": null,
      "status": "playing",
      "turnsMade": 3,
      "playerTurn": "81b18488-b023-4cb0-99e7-b247a4992290"
    }
  }
}
```

##### Get available games:
```
curl -X GET http://127.0.0.1/api/game
```

##### response:
```
{
  "status": "success",
  "data": {
    "games": [
      "64395a0d-1fb8-4f54-9f8c-9400d8494e36",
      "ad6231bc-7922-47b0-997b-ff8e2c68b80d"
    ]
  }
}
```

 