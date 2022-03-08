@REM @REM permet de commenter du code dans le terminal

@REM Supprimer les versions antérieurs de migration pour éviter les erreurs
@REM (Commande du systemene d'exploitation et non de symfony)
    echo yes | del migrations

@REM Pour créer la base de donnée cf env. pour le nom de la BD
    symfony console doctrine:database:create --no-interaction
    symfony console make:migration --no-interaction
    symfony console doctrine:migration:migrate --no-interaction

@REM supprime et recrée DB
    symfony console doctrine:fixtures:load --no-interaction

@REM ajoute dans la DB après donc risque doublons
    @REM symfony console doctrine:fixtures:load --append