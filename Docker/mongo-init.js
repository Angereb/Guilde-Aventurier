const baseSite = db.getSiblingDB(process.env.MONGO_DATABASE);
baseSite.createUser({
    user: process.env.MONGO_UTILISATEUR_SITE,
    pwd: process.env.MONGO_MOT_DE_PASSE_SITE,
    roles: [{ role: "readWrite", db: process.env.MONGO_DATABASE }]
});