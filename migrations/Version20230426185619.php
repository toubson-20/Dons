<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426185619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE donneur_campagne (donneur_id INT NOT NULL, campagne_id INT NOT NULL, PRIMARY KEY(donneur_id, campagne_id))');
        $this->addSql('CREATE INDEX IDX_F244BCB89789825B ON donneur_campagne (donneur_id)');
        $this->addSql('CREATE INDEX IDX_F244BCB816227374 ON donneur_campagne (campagne_id)');
        $this->addSql('CREATE TABLE hopital_campagne (hopital_id INT NOT NULL, campagne_id INT NOT NULL, PRIMARY KEY(hopital_id, campagne_id))');
        $this->addSql('CREATE INDEX IDX_35C9A745CC0FBF92 ON hopital_campagne (hopital_id)');
        $this->addSql('CREATE INDEX IDX_35C9A74516227374 ON hopital_campagne (campagne_id)');
        $this->addSql('ALTER TABLE donneur_campagne ADD CONSTRAINT FK_F244BCB89789825B FOREIGN KEY (donneur_id) REFERENCES donneur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE donneur_campagne ADD CONSTRAINT FK_F244BCB816227374 FOREIGN KEY (campagne_id) REFERENCES campagne (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hopital_campagne ADD CONSTRAINT FK_35C9A745CC0FBF92 FOREIGN KEY (hopital_id) REFERENCES hopital (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hopital_campagne ADD CONSTRAINT FK_35C9A74516227374 FOREIGN KEY (campagne_id) REFERENCES campagne (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        // $this->addSql('ALTER TABLE campagne ALTER date_debut TYPE DATE');
        $this->addSql('ALTER TABLE campagne ALTER COLUMN date_debut TYPE date USING date_debut::date');
        $this->addSql('ALTER TABLE campagne RENAME COLUMN nom TO intitule');
        // $this->addSql('ALTER TABLE departement ALTER code TYPE INT');
        // $this->addSql('ALTER TABLE departement ALTER code TYPE INT');
        $this->addSql('ALTER TABLE departement ALTER COLUMN code TYPE integer USING code::integer');
        $this->addSql('ALTER TABLE donneur DROP CONSTRAINT fk_4493d77316227374');
        $this->addSql('DROP INDEX idx_4493d77316227374');
        $this->addSql('ALTER TABLE donneur ADD sang VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE donneur DROP campagne_id');
        $this->addSql('ALTER TABLE donneur DROP type_de_sang');
        $this->addSql('ALTER TABLE donneur DROP date_de_naissance');
        $this->addSql('ALTER TABLE donneur ALTER telephone TYPE VARCHAR(20)');
        $this->addSql('ALTER TABLE dons DROP CONSTRAINT fk_e4f955facc0fbf92');
        $this->addSql('DROP INDEX idx_e4f955facc0fbf92');
        $this->addSql('ALTER TABLE dons ADD points_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dons ADD type VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE dons ADD commentaire VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE dons DROP hopital_id');
        $this->addSql('ALTER TABLE dons DROP type_de_don');
        $this->addSql('ALTER TABLE dons DROP statut');
        $this->addSql('ALTER TABLE dons DROP poids');
        $this->addSql('ALTER TABLE dons DROP commentaires');
        $this->addSql('ALTER TABLE dons ALTER donneur_id DROP NOT NULL');
        $this->addSql('ALTER TABLE dons ADD CONSTRAINT FK_E4F955FADF69572F FOREIGN KEY (points_id) REFERENCES points (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E4F955FADF69572F ON dons (points_id)');
        $this->addSql('ALTER TABLE hopital DROP CONSTRAINT fk_8718f2c16227374');
        $this->addSql('DROP INDEX idx_8718f2c16227374');
        $this->addSql('ALTER TABLE hopital ALTER telephone SET NOT NULL');
        $this->addSql('ALTER TABLE hopital ALTER telephone TYPE VARCHAR(20)');
        $this->addSql('ALTER TABLE hopital RENAME COLUMN campagne_id TO dons_id');
        $this->addSql('ALTER TABLE hopital ADD CONSTRAINT FK_8718F2CDDBFD07B FOREIGN KEY (dons_id) REFERENCES dons (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8718F2CDDBFD07B ON hopital (dons_id)');
        $this->addSql('ALTER TABLE points DROP CONSTRAINT fk_27ba8e29ddbfd07b');
        $this->addSql('DROP INDEX idx_27ba8e29ddbfd07b');
        $this->addSql('ALTER TABLE points ADD code VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE points ADD quantite INT NOT NULL');
        $this->addSql('ALTER TABLE points DROP dons_id');
        $this->addSql('ALTER TABLE points DROP "quantité"');
        $this->addSql('ALTER TABLE points ALTER donneur_id DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE donneur_campagne DROP CONSTRAINT FK_F244BCB89789825B');
        $this->addSql('ALTER TABLE donneur_campagne DROP CONSTRAINT FK_F244BCB816227374');
        $this->addSql('ALTER TABLE hopital_campagne DROP CONSTRAINT FK_35C9A745CC0FBF92');
        $this->addSql('ALTER TABLE hopital_campagne DROP CONSTRAINT FK_35C9A74516227374');
        $this->addSql('DROP TABLE donneur_campagne');
        $this->addSql('DROP TABLE hopital_campagne');
        $this->addSql('ALTER TABLE hopital DROP CONSTRAINT FK_8718F2CDDBFD07B');
        $this->addSql('DROP INDEX UNIQ_8718F2CDDBFD07B');
        $this->addSql('ALTER TABLE hopital ALTER telephone DROP NOT NULL');
        $this->addSql('ALTER TABLE hopital ALTER telephone TYPE VARCHAR(30)');
        $this->addSql('ALTER TABLE hopital RENAME COLUMN dons_id TO campagne_id');
        $this->addSql('ALTER TABLE hopital ADD CONSTRAINT fk_8718f2c16227374 FOREIGN KEY (campagne_id) REFERENCES campagne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8718f2c16227374 ON hopital (campagne_id)');
        $this->addSql('ALTER TABLE departement ALTER code TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE campagne ALTER date_debut TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE campagne RENAME COLUMN intitule TO nom');
        $this->addSql('ALTER TABLE points ADD "quantité" INT NOT NULL');
        $this->addSql('ALTER TABLE points DROP code');
        $this->addSql('ALTER TABLE points ALTER donneur_id SET NOT NULL');
        $this->addSql('ALTER TABLE points RENAME COLUMN quantite TO dons_id');
        $this->addSql('ALTER TABLE points ADD CONSTRAINT fk_27ba8e29ddbfd07b FOREIGN KEY (dons_id) REFERENCES dons (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_27ba8e29ddbfd07b ON points (dons_id)');
        $this->addSql('ALTER TABLE dons DROP CONSTRAINT FK_E4F955FADF69572F');
        $this->addSql('DROP INDEX UNIQ_E4F955FADF69572F');
        $this->addSql('ALTER TABLE dons ADD hopital_id INT NOT NULL');
        $this->addSql('ALTER TABLE dons ADD type_de_don VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE dons ADD statut VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE dons ADD poids INT NOT NULL');
        $this->addSql('ALTER TABLE dons ADD commentaires VARCHAR(300) DEFAULT NULL');
        $this->addSql('ALTER TABLE dons DROP points_id');
        $this->addSql('ALTER TABLE dons DROP type');
        $this->addSql('ALTER TABLE dons DROP commentaire');
        $this->addSql('ALTER TABLE dons ALTER donneur_id SET NOT NULL');
        $this->addSql('ALTER TABLE dons ADD CONSTRAINT fk_e4f955facc0fbf92 FOREIGN KEY (hopital_id) REFERENCES hopital (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_e4f955facc0fbf92 ON dons (hopital_id)');
        $this->addSql('ALTER TABLE donneur ADD campagne_id INT NOT NULL');
        $this->addSql('ALTER TABLE donneur ADD type_de_sang VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE donneur ADD date_de_naissance VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE donneur DROP sang');
        $this->addSql('ALTER TABLE donneur ALTER telephone TYPE VARCHAR(30)');
        $this->addSql('ALTER TABLE donneur ADD CONSTRAINT fk_4493d77316227374 FOREIGN KEY (campagne_id) REFERENCES campagne (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_4493d77316227374 ON donneur (campagne_id)');
    }
}
