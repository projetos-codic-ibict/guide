# GUIDE MAKER DATAVERSE

## Instalando o Banco de dados

Configue o arquivo .env com os dados do banco

 php spark db:create guide2

Crie a estrutura do banco de dados

 php spark migrate

 # Ativar o novo User Guide no Dataverse

  curl -X PUT -d http://example.edu/dvn/guide http://localhost:8080/api/admin/settings/:NavbarGuidesUrl

  curl -X PUT -d http://example.edu/dvn/guide http://localhost:8080/api/admin/settings/:GuidesBaseUrl

  curl -X PUT -d v1 http://localhost:8080/api/admin/settings/:GuidesVersion
