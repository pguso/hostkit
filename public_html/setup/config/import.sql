--
-- Table structure for table `api_key`
--

DROP TABLE IF EXISTS `api_key`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_key`
--

LOCK TABLES `api_key` WRITE;
/*!40000 ALTER TABLE `api_key` DISABLE KEYS */;
/*!40000 ALTER TABLE `api_key` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_user`
--

DROP TABLE IF EXISTS `api_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `server_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cost` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `max_user` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `debug_modus` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domain` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ssl` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auto_jobs`
--

DROP TABLE IF EXISTS `auto_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auto_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domains` int(11) NOT NULL,
  `hosting` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auto_jobs`
--

LOCK TABLES `auto_jobs` WRITE;
/*!40000 ALTER TABLE `auto_jobs` DISABLE KEYS */;
INSERT INTO `auto_jobs` VALUES (1,1,1);
/*!40000 ALTER TABLE `auto_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) NOT NULL,
  `domain` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tld` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_cycle` int(11) DEFAULT NULL,
  `sessionId` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `clientId` int(11) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `domainMode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `client_order`
--

DROP TABLE IF EXISTS `client_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_update` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `memo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip_address` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoice_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shipping_first_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_last_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_address1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_address2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_state` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_postal_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_cost` decimal(10,2) DEFAULT NULL,
  `payment_first_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_last_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_address1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_address2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_state` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_postal_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_method` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `domain_mail`
--

DROP TABLE IF EXISTS `domain_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `domain_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `alternative` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domainId` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `domain_pricing`
--

DROP TABLE IF EXISTS `domain_pricing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `domain_pricing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `period` int(11) NOT NULL,
  `tld` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price_euro` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price_usd` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cost` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `email`
--

DROP TABLE IF EXISTS `email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contentTop` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contentInner` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email`
--

LOCK TABLES `email` WRITE;
/*!40000 ALTER TABLE `email` DISABLE KEYS */;
INSERT INTO `email` VALUES (1,'signup','Welcome',NULL,'<p>Dear {{ client.name }},</p>\r\n\r\n<p>Thank you for signing up with us. Your new account has been setup and you can now login to our client area using the details below.</p>\r\n\r\n<p>Email Address: {{ client.email }}<br />\r\nPassword: {{ password }}</p>\r\n\r\n<p>{{ settings.signature }}</p>','To login, visit {{ settings.url }}'),(5,'account_approved','Account Approved',NULL,'<p>Dear {{ client.name }},</p>\r\n\r\n<p>Your account has now been approved!<br />\r\nThis means that your account is now active and the details that were sent in your previous email now work. You can proceed to your hosting control panel.</p>\r\n\r\n<p>{{ settings.signature }}</p>',NULL),(6,'account_cancelled','Account Cancelled',NULL,'<p>Dear {{ client.name }},</p>\r\n\r\n<p>Your account has been cancelled!<br />\r\nThis now means that your client username and password no longer work and your web hosting package no longer exists. All your files, databases, records have been removed and aren&#39;t retrievable.<br />\r\n<br />\r\nReason for cancellation: {{ reason }}</p>',NULL),(7,'admin_ticket','New Support Ticket',NULL,'<p><strong>A Client has posted a new ticket!</strong><br />\r\nThe ticket is awaiting your staff reply, please look at it ASAP. It&#39;s details:<br />\r\n<br />\r\n<strong>Title: </strong>{{ support.title }}<br />\r\n<strong>Priority: </strong>{{ support.priority }}<br />\r\n<strong>Subject: </strong>{{ support.subject }}</p>',NULL),(8,'support_ticket_response','Support Ticket Response',NULL,'<p>{{ client.name }} has replied to the ticket {{ support.subject }} and now is awaiting your response!</p>\r\n\r\n<p><br />\r\nPlease look at the ticket ASAP and try to resolve the problem.</p>',NULL),(9,'awaiting_validation','Awaiting Validation',NULL,'<p>{{ client.name }} is awaiting for validation!<br />\r\nLog into your Admin Interface now to approve or decline that client.</p>','Login Url: {{ settings.url }}'),(10,'reset_password','Password Reset',NULL,'<p>Your Admin Interface password has been reset!<br />\r\nNew Password: {{ password }}<br />\r\n<br />\r\n<span style=\"color:#ff0000\"><strong>Notice!</strong><br />\r\n<span style=\"color:#000000\">If you didn&#39;t use the forgot password feature, we suggest you log into Admin Interface with your new password and use a different email.</span></span></p>',NULL),(11,'validation_info','Awaiting Validation',NULL,'<p>Dear {{ client.name }},</p>\r\n\r\n<p>Your account is awaiting admin validation!<br />\r\nYour account has been successfully created but you need to wait for an admin to approve your account! You&#39;re now able to log into your client control panel. Your details are as follows:</p>\r\n\r\n<p>Username: {{ username }}<br />\r\nPassword: {{ password }}<br />\r\nEmail: {{ client.email }}<br />\r\nDomain/Subdomain: {{ client.domain }}<br />\r\nPackage: {{ client.package }}<br />\r\n&nbsp;</p>','Please confirm your E-Mail Address here {{ settings.confirm_url }}'),(12,'client_reset_password','New Password',NULL,'<p>Your password has been reset!<br />\r\nNew Password: {{ password }}<br />\r\n<br />\r\n<span style=\"color:#ff0000\">Notice!<br />\r\n<span style=\"color:#000000\">If you didn&#39;t use the forgot password feature, we suggest you log into client area with your new password and use a different email.</span></span></p>',NULL),(13,'suspended','Account Suspended',NULL,'<p>Dear {{ client.name }},</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Your Account Has Been Suspended!</p>\r\n\r\n<p><br />\r\nThis means that your site on control panel is no longer accessable. Your website and all its content still remain intact. Contact your host for further details.</p>',NULL),(14,'email_validation','Please confirm your E-Mail Address',NULL,'<p>Dear {{ client.name }},</p>\r\n\r\n<p>Please confirm the email address associated with your hosting account by clicking the link below.</p>\r\n\r\n<p><a href=\"https://demos4.softaculous.com/TheHostingTool/admin/%CONFIRM%\">{{ settings.confirm_url }}</a></p>',NULL),(15,'new_hosting_account','Hosting Account Details',NULL,'<p>Dear {{ client.name }},</p>\r\n\r\n<p>your account has been successfully created and you&#39;re now able to log into your client control panel and your web hosting control panel. Your details are as follows:</p>\r\n\r\n<p>Username: {{ username }}<br />\r\nPassword: {{ password }}<br />\r\nEmail: {{ client.email }}<br />\r\nDomain/Subdomain: {{ domain }}<br />\r\nPackage: {{ package }}</p>\r\n\r\n<p>You can login to your new Hosting Account here:</p>\r\n\r\n<p><a href=\"https://{{ server.ipAddress }}:2083\">https://{{ server.ipAddress }}:2083</a></p>\r\n\r\n<p>&nbsp;</p>',NULL),(16,'new_invoice','New Invoice',NULL,'<p>Dear {{ client.name }},</p>\r\n\r\n<p>You have a new invoice on your account.</p>\r\n\r\n<p><strong>Invoice Due: </strong>{{ invoice.due }}</p>\r\n\r\n<p>You can view the details of this invoice in our client interface.</p>\r\n\r\n<p>Thank you for ensuring prompt payment of this invoice.</p>\r\n\r\n<p>Payments should be received within 7 days from the date of this invoice. Failure to remit payment within 7 days will result in account suspension. Failure to remit payment within 30 days will result in account termination.<br />\r\n&nbsp;</p>\r\n\r\n<p>{{ settings.signature }}</p>',NULL),(17,'client_new_ticket_response','New Ticket Response',NULL,'<p>Dear {{ client.name }},</p>\r\n\r\n<p><strong>{{ support.staff }} has replied to your ticket!</strong></p>\r\n\r\n<p>To view this ticket, please login to your support area and check.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Subject: {{ support.subject }}</p>\r\n\r\n<p>Message: {{ support.message }}</p>',NULL),(18,'unsuspended_account','Unsuspended Account',NULL,'<div style=\"color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; background-image: initial; background-repeat: initial; background-attachment: initial; -webkit-background-clip: initial; -webkit-background-origin: initial; background-color: #ffffff; background-position: initial initial; margin: 8px;\">\r\n<p>Dear {{ client.name }},</p>\r\n\r\n<p>Your Account Has Been Unsuspended!<br />\r\nThis means that your site on control panel is now accessable. Your website and all its content still remain intact and can be accessed.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>{{ settings.signature }}</p>\r\n</div>',NULL),(19,'order_confirmartion','Thank You for your Order!',NULL,'<p>Dear {{ client.name }},</p>\r\n\r\n<p>we appreciate your business and look forward to a long-lasting business relationship!</p>\r\n\r\n<p>Items included in this order:</p>\r\n\r\n<p>{{ order.items }}</p>\r\n\r\n<p><br />\r\nTotal charges for this invoice: {{ order.total }}</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Our team is ready to assist you with your account if you need any help! However, should you ever wish to cancel your account, simply submit your cancellation request from Client Interface. All of our legal information including Terms of Service, Privacy Policy, and cancellation policy are always available to you on our website:</p>\r\n\r\n<p>{{ settings.url }}<br />\r\n<br />\r\nWe hope you enjoy your services with us, and we thank you again for your order!</p>\r\n\r\n<p>{{ settings.signature }}</p>',NULL),(20,'admin_new_order','Order - Payment Success',NULL,'<p>Hello,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Client {{ client.name }} has paid his order. You didnt enabled automated Account Setup. Please setup hosting and/or Domain Service and send the Details to {{ client.email }}.</p>\r\n\r\n<p>&nbsp;</p>',NULL),(21,'domain_register_successfull','Your Domain',NULL,'<p>Dear {{ client.name }},</p>\r\n\r\n<p>thank you for your order.</p>\r\n\r\n<p>We setup your new Domain {{ domain }}, you can now login to the client interface and configure your domain settings.</p>\r\n\r\n<p>{{ settings.signature }}</p>','Login Url: {{ settings.url }}');
/*!40000 ALTER TABLE `email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expercash`
--

DROP TABLE IF EXISTS `expercash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expercash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paymentMethod` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expercash`
--

LOCK TABLES `expercash` WRITE;
/*!40000 ALTER TABLE `expercash` DISABLE KEYS */;
/*!40000 ALTER TABLE `expercash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `answer` varchar(1500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `faq_category`
--

DROP TABLE IF EXISTS `faq_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `paymentDate` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userId` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `orderItemId` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `paymentMethod` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoice_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `knowledgebase_article`
--

DROP TABLE IF EXISTS `knowledgebase_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knowledgebase_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `knowledgebase_category`
--

DROP TABLE IF EXISTS `knowledgebase_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knowledgebase_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knowledgebase_category`
--

LOCK TABLES `knowledgebase_category` WRITE;
/*!40000 ALTER TABLE `knowledgebase_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `knowledgebase_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heading` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `details` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `last_update` datetime DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `service` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `term_length` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_period` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `package_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `package_domain` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `details` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `invoice_date` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `popupId` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paymentMethod` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `returnUrl` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `errorUrl` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notifyUrl` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `currencyCode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `vat` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (1,'paypal',NULL,NULL,NULL,NULL,NULL,'','https://www.paypal.com/cgi-bin/webscr','','USD','');
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_transaction`
--

DROP TABLE IF EXISTS `payment_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `invoice` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `residenceCountry` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `paymentDate` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `verifySign` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `payerEmail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `txnType` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `payerStatus` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mcCurrency` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `paymentType` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `paymentStatus` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `addressStatus` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catId` int(11) DEFAULT NULL,
  `typeId` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `setup` decimal(10,2) DEFAULT NULL,
  `description` varchar(330) COLLATE utf8_unicode_ci NOT NULL,
  `payment` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `createdAt` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `uuid` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `featured` int(11) DEFAULT NULL,
  `options` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `assets` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updateAt` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  `term_length` int(11) DEFAULT NULL,
  `price_per_period` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discount` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total` varchar(55) COLLATE utf8_unicode_ci DEFAULT NULL,
  `monthly` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quarterly` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `semiannual` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `annual` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msetup` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qsetup` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ssetup` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `asetup` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mdiscount` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qdiscount` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdiscount` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `adiscount` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cpanel_package` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `product_attribute`
--

DROP TABLE IF EXISTS `product_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_attribute`
--

LOCK TABLES `product_attribute` WRITE;
/*!40000 ALTER TABLE `product_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_subscription`
--

DROP TABLE IF EXISTS `product_subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `monthly` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `quarterly` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `semiannual` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `annual` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `msetup` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `qsetup` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ssetup` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `asetup` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_subscription`
--

LOCK TABLES `product_subscription` WRITE;
/*!40000 ALTER TABLE `product_subscription` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_type`
--

DROP TABLE IF EXISTS `product_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_type`
--

LOCK TABLES `product_type` WRITE;
/*!40000 ALTER TABLE `product_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server`
--

DROP TABLE IF EXISTS `server`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(1500) COLLATE utf8_unicode_ci NOT NULL,
  `accounts` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cost` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `used` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyName` varchar(155) COLLATE utf8_unicode_ci NOT NULL,
  `companyAddress1` varchar(155) COLLATE utf8_unicode_ci NOT NULL,
  `companyPostcode` varchar(155) COLLATE utf8_unicode_ci NOT NULL,
  `companyCity` varchar(155) COLLATE utf8_unicode_ci NOT NULL,
  `companyCountry` varchar(155) COLLATE utf8_unicode_ci NOT NULL,
  `companyOwner` varchar(155) COLLATE utf8_unicode_ci DEFAULT NULL,
  `companyEmail` varchar(155) COLLATE utf8_unicode_ci DEFAULT NULL,
  `companyPhone` varchar(155) COLLATE utf8_unicode_ci DEFAULT NULL,
  `autoJobsDomains` int(11) DEFAULT NULL,
  `autoJobsHosting` int(11) DEFAULT NULL,
  `facebook` varchar(155) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(155) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google` varchar(155) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domain` varchar(155) COLLATE utf8_unicode_ci DEFAULT NULL,
  `signature` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `companyState` varchar(155) COLLATE utf8_unicode_ci NOT NULL,
  `confirm_url` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `terms_conditions` varchar(3000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supportEmail` varchar(155) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domainReseller` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domainUser` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domainPassword` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UStID` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `site`
--

DROP TABLE IF EXISTS `site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(15555) COLLATE utf8_unicode_ci NOT NULL,
  `menu` int(11) NOT NULL,
  `name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `createdAt` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_694309E45E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `statistic_clients`
--

DROP TABLE IF EXISTS `statistic_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistic_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_clients`
--

LOCK TABLES `statistic_clients` WRITE;
/*!40000 ALTER TABLE `statistic_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `statistic_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistic_invoices`
--

DROP TABLE IF EXISTS `statistic_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistic_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_invoices`
--

LOCK TABLES `statistic_invoices` WRITE;
/*!40000 ALTER TABLE `statistic_invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `statistic_invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistic_marketing`
--

DROP TABLE IF EXISTS `statistic_marketing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistic_marketing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_marketing`
--

LOCK TABLES `statistic_marketing` WRITE;
/*!40000 ALTER TABLE `statistic_marketing` DISABLE KEYS */;
/*!40000 ALTER TABLE `statistic_marketing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistic_orders`
--

DROP TABLE IF EXISTS `statistic_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistic_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_orders`
--

LOCK TABLES `statistic_orders` WRITE;
/*!40000 ALTER TABLE `statistic_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `statistic_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistic_sales`
--

DROP TABLE IF EXISTS `statistic_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistic_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistic_sales`
--

LOCK TABLES `statistic_sales` WRITE;
/*!40000 ALTER TABLE `statistic_sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `statistic_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_department`
--

DROP TABLE IF EXISTS `support_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_department`
--

LOCK TABLES `support_department` WRITE;
/*!40000 ALTER TABLE `support_department` DISABLE KEYS */;
INSERT INTO `support_department` VALUES (1,'Default','General Department');
/*!40000 ALTER TABLE `support_department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_ticket`
--

DROP TABLE IF EXISTS `support_ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `closed_at` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `parentId` int(11) DEFAULT NULL,
  `related` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `register_date` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','admin','admin@url.de','admin@url.de',1,'79dur41vwlc0gkso8k0gkskcksg4os8','PbXsNqZRsbMbCseqrUbmsHEPRHnSc6xTuxXYarBufStfAFisIJNnCivjtRD/5Wjk7G0+lD++e5twcueqoh99mQ==','2014-02-28 13:54:33',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,NULL);
