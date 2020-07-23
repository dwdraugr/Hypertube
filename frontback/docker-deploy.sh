docker-compose down -v && docker-compose up -d db
echo "waiting start db\n"
sleep 25s
docker-compose up -d
