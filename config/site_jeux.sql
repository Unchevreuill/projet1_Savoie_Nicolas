-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 20 déc. 2023 à 15:12
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `site_jeux`
--

-- --------------------------------------------------------

--
-- Structure de la table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `street_nb` int(11) NOT NULL,
  `street_name` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `province` varchar(20) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `country` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `addresses`
--

INSERT INTO `addresses` (`id`, `street_nb`, `street_name`, `city`, `province`, `zip_code`, `country`) VALUES
(1, 5915, 'Av des erables', 'Montreal', 'Quebec', 'H2G2M6', 'Canada'),
(2, 7, 'wahet mareth el waha', 'tunis', 'tunis', '2087', 'Tunisie');

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `ref` varchar(40) NOT NULL,
  `date` date NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_has_product`
--

CREATE TABLE `order_has_product` (
  `id_order` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `url_img` varchar(60) NOT NULL,
  `description` varchar(100) NOT NULL,
  `console` varchar(20) NOT NULL,
  `year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `name`, `qty`, `price`, `url_img`, `description`, `console`, `year`) VALUES
(1, 'Fifa 19', 100, 60, '', 'fifa', 'pc', '2018'),
(2, 'FC24', 50, 120, '', 'aejrbhiewtb', 'ps4', '2023'),
(3, 'Resdent evil', 500, 50, '', 'davfdv dsvfd', 'pc', '2016');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`role_id`, `name`, `description`) VALUES
(1, 'admin', 'admin'),
(2, 'user', 'user');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `pwd` varchar(40) NOT NULL,
  `username` varchar(20) NOT NULL,
  `Billing_adress` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `shipping_address` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `pwd`, `username`, `Billing_adress`, `role_id`, `shipping_address`) VALUES
(2, 'chahinehouidhek2@gmail.com', 'Chhca1920', 'chahine', 1, 1, 0),
(3, 'safwenhouidhek@gmail.com', 'safou', 'safwen', 2, 2, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`id_user`);

--
-- Index pour la table `order_has_product`
--
ALTER TABLE `order_has_product`
  ADD PRIMARY KEY (`id_order`,`id_product`),
  ADD KEY `fk_produit` (`id_product`),
  ADD KEY `id_order` (`id_order`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_role` (`role_id`),
  ADD KEY `fk_address` (`Billing_adress`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `order_has_product`
--
ALTER TABLE `order_has_product`
  ADD CONSTRAINT `fk_order` FOREIGN KEY (`id_order`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_produit` FOREIGN KEY (`id_product`) REFERENCES `produit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_address` FOREIGN KEY (`Billing_adress`) REFERENCES `addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
