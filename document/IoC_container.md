Now the logic is clear and very lucid to follow. Now we are free to change the data target any time just changing inside the class or creating another class. Here we have used 'MySql' but we can change it any time to any database you like. The most important thing is that our controller would never know what is going on inside. But the final hacking lies inside our ‘route’ file, because we have to bind the class and the interface and the great IoC container plays the pivotal role here. This is very simple with your ‘App’ Facades.

https://laravel.kr/docs/8.x/container#%EA%B0%84%EB%8B%A8%ED%95%9C%20%EB%B0%94%EC%9D%B8%EB%94%A9

As you see, our App' Facades bind the class and interface together so that a nice layer has been included between our data source and the transport mechanism. Moreover, our controller does not know about what has been going on inside that layer. Our application becomes more decoupled and you easily test it with 'phpUnit' without directly hitting the database.

We normally organize our transport mechanism or web layer through controller class. So this is a good practice to make it ignorant about our domain logic and use interfaces as a medium between web and data layer. Through controller classes we organize our route-level logic and besides we can use modern features like dependency injections.
Use interface and let controllers maintain their singularity of job which should be concerned only with the web layer. Since we use Composer to autoload our PHP classes, it can live anywhere in the file system as long as controller knows about it. And routing to controller is entirely decoupled from the file system. Resourceful controllers usually make RESTful controller around resources. Finally, we can conclude with the filter part, which is extremely important in managing the administration of an application. You can either control it through route level or explicitly use it inside your controller.

- beginning laravel -
