Para probar en tu máquina:

https://github.com/viniciuspasini/prueba_tecnica

1. Clona el repositorio

2. Ejecuta los siguientes comandos:
       composer install;
       php bin/console doctrine:migrations:migrate;

3. Usa los comandos:
       php bin/console app:create-campaign
       php bin/console app:list-campaigns
       php bin/console app:assign-influencer id_campaign id_influencer

4.DB
Como usé SQLite, no es necesario ejecutar ningún comando para crear la base de datos, ya que el archivo var/data_dev.db y las migrations ya están creadas en el proyecto.

5. Observaciones:
       Al asignar una campaña a un influencer, se creará una nueva fila en la tabla campaign_influencer donde se almacena la relación entre la campaña y el influencer.
