
DROP TABLE IF EXISTS `categorie_produits`;
CREATE TABLE IF NOT EXISTS `categorie_produits`
(
 `id_cat`  int(1) NOT NULL ,
 `nom_cat` varchar(45) NOT NULL ,

PRIMARY KEY (`id_cat`)
);



DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits`
(
 `id_produits`   int(2) NOT NULL AUTO_INCREMENT ,
 `nom_produits`  varchar(100) NOT NULL ,
 `desc_produits` varchar(200) NOT NULL ,
 `prix_produits` decimal(10, 2) NOT NULL ,
 `img_produits`  mediumblob NOT NULL ,
 `id_cat`        int(1) NOT NULL ,

PRIMARY KEY (`id_produits`),
KEY `FK_1` (`id_cat`),
CONSTRAINT `FK_31` FOREIGN KEY `FK_1` (`id_cat`) REFERENCES `categorie_produits` (`id_cat`)
);

INSERT INTO `produits` (`nom_produits`, `desc_produits`, `prix_produits`, `img_produits`, `id_cat`) VALUES
('Evian', 'Eau minérale naturelle des Alpes françaises.', 1.50, NULL, 0),
('Perrier', 'Eau minérale naturelle gazeuse française.', 1.70, NULL, 1),
('Vittel', 'Eau minérale naturelle source de vitalité.', 1.40, NULL, 0),
('San Pellegrino', 'Eau minérale naturelle gazeuse italienne.', 1.90, NULL, 1),
('Volvic', "Eau minérale naturelle du volcan d'Auvergne.", 1.45, NULL, 0),
('Badoit', 'Eau minérale gazeuse légèrement pétillante.', 1.80, NULL, 1),
('Contrex', 'Eau minérale naturelle riche en minéraux.', 1.35, NULL, 0),
('Hépar', 'Eau minérale naturelle aidant à la digestion.', 1.55, NULL, 0),
('Cristaline', 'Eau de source française pure et légère.', 1.20, NULL, 0),
('Orezza', 'Eau minérale gazeuse de la Corse.', 1.95, NULL, 1),
('Thonon', 'Eau minérale naturelle des Alpes.', 1.30, NULL, 0),
('La Salvetat', 'Eau minérale gazeuse naturelle.', 1.85, NULL, 1),
('Rozana', 'Eau minérale riche en magnésium.', 1.60, NULL, 0),
('Mont Roucous', 'Eau minérale naturelle pour toute la famille.', 1.25, NULL, 0),
('Chaudfontaine', 'Eau minérale naturelle chauffée en profondeur.', 1.70, NULL, 0),
('Fiji', 'Eau de source exotique des îles Fidji.', 2.10, NULL, 0),
('Acqua Panna', 'Eau minérale naturelle italienne.', 1.65, NULL, 0),
('Dasani', 'Eau purifiée rafraîchissante.', 1.15, NULL, 0),
('Aquafina', 'Eau purifiée pour une hydratation quotidienne.', 1.20, NULL, 0),
('Gerolsteiner', 'Eau minérale gazeuse allemande.', 1.95, NULL, 1),
('Icelandic Glacial', "Eau de source venue d'Islande.", 2.00, NULL, 0),
('Svalbardi', 'Eau de source polaire premium.', 3.50, NULL, 0),
('Smartwater', "Eau distillée avec ajout d'électrolytes.", 1.40, NULL, 0),
('Highland Spring', 'Eau de source écossaise.', 1.55, NULL, 0),
('Lifewtr', "Eau purifiée pour inspirer l'esprit.", 1.30, NULL, 0);


DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note`
(
 `id_note`     int NOT NULL AUTO_INCREMENT ,
 `id_produits` int(2) NOT NULL ,
 `note`        int(1) NOT NULL ,
 `datetime_note`    datetime NOT NULL,

PRIMARY KEY (`id_note`, `id_produits`),
KEY `FK_1` (`id_produits`),
CONSTRAINT `FK_33` FOREIGN KEY `FK_1` (`id_produits`) REFERENCES `produits` (`id_produits`)
);


