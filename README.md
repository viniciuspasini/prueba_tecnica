Para probar en tu máquina:

https://github.com/viniciuspasini/prueba_tecnica

1. Clona el repositorio

2. Ejecuta los siguientes comandos:<br>
       composer install;<br>
       php bin/console doctrine:migrations:migrate;<br>

3. Usa los comandos:<br>
       php bin/console app:create-campaign<br>
       php bin/console app:list-campaigns<br>
       php bin/console app:assign-influencer id_campaign id_influencer<br>

4.DB<br>
Como usé SQLite, no es necesario ejecutar ningún comando para crear la base de datos, ya que el archivo var/data_dev.db y las migrations ya están creadas en el proyecto.<br>

5. Observaciones:<br>
       Al asignar una campaña a un influencer, se creará una nueva fila en la tabla campaign_influencer donde se almacena la relación entre la campaña y el influencer.
