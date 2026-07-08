<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260708123805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_devis ADD CONSTRAINT FK_7DF9460219EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE demande_devis ADD CONSTRAINT FK_7DF946029E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE demande_devis ADD CONSTRAINT FK_7DF946024E853A9E FOREIGN KEY (ouvrier_id) REFERENCES ouvrier (id)');
        $this->addSql('ALTER TABLE gallery_image_modale ADD CONSTRAINT FK_24F679AC357C0A59 FOREIGN KEY (tarif_id) REFERENCES tarif (id)');
        $this->addSql('ALTER TABLE image_prestation ADD CONSTRAINT FK_3D16989B9E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE9E45C554 FOREIGN KEY (prestation_id) REFERENCES prestation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_devis DROP FOREIGN KEY FK_7DF9460219EB6921');
        $this->addSql('ALTER TABLE demande_devis DROP FOREIGN KEY FK_7DF946029E45C554');
        $this->addSql('ALTER TABLE demande_devis DROP FOREIGN KEY FK_7DF946024E853A9E');
        $this->addSql('ALTER TABLE gallery_image_modale DROP FOREIGN KEY FK_24F679AC357C0A59');
        $this->addSql('ALTER TABLE image_prestation DROP FOREIGN KEY FK_3D16989B9E45C554');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE9E45C554');
    }
}
