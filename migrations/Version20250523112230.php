<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250523112230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE campaign_influencer (campana_id INTEGER NOT NULL, influencers_id INTEGER NOT NULL, PRIMARY KEY(campana_id, influencers_id), CONSTRAINT FK_FA88AC0BCAF4BE34 FOREIGN KEY (campana_id) REFERENCES campana (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FA88AC0BD88E4287 FOREIGN KEY (influencers_id) REFERENCES influencers (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FA88AC0BCAF4BE34 ON campaign_influencer (campana_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FA88AC0BD88E4287 ON campaign_influencer (influencers_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE campaign_influencer
        SQL);
    }
}
