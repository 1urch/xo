# Xs and Os ![coverage](https://img.shields.io/badge/coverage-71%25-yellowgreen.svg)
An attempt to implement turn-based strategy game

####RU

Это репозиторий моего пет-проекта. Я задумал его, как песочницу для исследования возможностей реализации пошаговой стратегической игры. Целями этого проекта являются: изучение и применение методик и паттернов разработки, проверка гипотез, исследование нововведений php, изучение технологий. Так же этот проект может быть полезен в качестве репрезентации моих навыков разработчика.

Этот репозиторий содержит реализацию серверной части приложения для игры в крестики-нолики. Но это только начало. В планах реализовать гораздо более сложную пошаговую стратегию c гексагональными полями и роботами <img src="https://assets-cdn.github.com/images/icons/emoji/suspect.png" width="20" height="20">.

В основе архитектуры приложения лежит принцип разделения команды/запросы. Это не означает, что в приложении реализован паттерн CQRS, но в перспективе проект может обзавестись им, включая Event Soursing.

Приложение работает благодаря фреймворку Silex. Но вообще, руководствуясь CQS принципом я реализовал framework-agnostic архитектуру, что позволит без особых потерь сменить фреймворк, например на Symfony 4.

В качестве хранилища данных для чтения и записи используется одна реляционная БД MySQL, в качестве слоя абстракции БД используется Doctrine ORM.

Для удобства разработки я использую среду основанную на docker контейнерах. 

Общение с API приложения осуществляется на основе HTTP протокола (используя методы POST и GET). В качестве ответа сервер предоставляет json данные, структура которых наследует спецификацию jsend.

####EN

This is the repository of my pet-project which i planned out as a sandbox to explore the possibilities of implementing a turn-based strategic game. The purposes of this project are: studying and applying some techniques and development patterns, confirming my hypothesis, exploring language innovations and the research of technologies. Also, this project is a representation of my developer skills.

This project implements the tic-tac-toe application server, but there are plans to develop a much more complex turn-based strategic game that includes hexagonal fields and robots <img src = "https://assets-cdn.github.com/images/icons/emoji/suspect.png" width = "20" height = "20" >.

The application architecture is based on the principle of command-query separation. This does not mean that the application implements the CQRS pattern, but in the long term it can be included, as well as Event Sourсing.

The application works with Silex framework but is, in general, guided by the CQS principle which is making the architecture framework-agnostic. That would allow changing the framework without much loss.

I used one relational db (MySQL) as a data storage both for reading and writing, and Doctrine ORM as the database abstraction layer.

For the convenience of development, i used a docker-based environment.

API is built on top of HTTP protocol (using the POST and GET methods). In response, the server provides json data which structure inherits the [jsend](https://labs.omniti.com/labs/jsend) specification.

 