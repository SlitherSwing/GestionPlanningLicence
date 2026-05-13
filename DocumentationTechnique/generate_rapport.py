from fpdf import FPDF

class PDF(FPDF):
    def header(self):
        self.set_font("Helvetica", "B", 10)
        self.set_text_color(100, 100, 100)
        self.cell(0, 8, "Rapport CDC - Gestion Licence", align="C", new_x="LMARGIN", new_y="NEXT")
        self.line(10, self.get_y(), 200, self.get_y())
        self.ln(4)

    def footer(self):
        self.set_y(-15)
        self.set_font("Helvetica", "I", 8)
        self.set_text_color(150, 150, 150)
        self.cell(0, 10, f"Page {self.page_no()}/{{nb}}", align="C")

    def section_title(self, title):
        self.set_font("Helvetica", "B", 13)
        self.set_text_color(30, 60, 120)
        self.cell(0, 10, title, new_x="LMARGIN", new_y="NEXT")
        self.set_draw_color(30, 60, 120)
        self.line(10, self.get_y(), 200, self.get_y())
        self.ln(3)

    def sub_title(self, title):
        self.set_font("Helvetica", "B", 11)
        self.set_text_color(50, 50, 50)
        self.cell(0, 8, title, new_x="LMARGIN", new_y="NEXT")

    def body_text(self, text):
        self.set_font("Helvetica", "", 10)
        self.set_text_color(40, 40, 40)
        self.multi_cell(0, 5.5, text)
        self.ln(1)

    def check(self, text):
        self.set_font("Helvetica", "", 10)
        self.set_text_color(34, 139, 34)
        self.cell(5, 5.5, "")
        self.cell(0, 5.5, text, new_x="LMARGIN", new_y="NEXT")

    def cross(self, text):
        self.set_font("Helvetica", "", 10)
        self.set_text_color(200, 30, 30)
        self.cell(5, 5.5, "")
        self.cell(0, 5.5, text, new_x="LMARGIN", new_y="NEXT")

    def status_ok(self):
        self.set_font("Helvetica", "B", 10)
        self.set_text_color(34, 139, 34)
        self.cell(0, 6, "Statut : IMPLIMENTE", new_x="LMARGIN", new_y="NEXT")
        self.ln(2)

    def status_partial(self):
        self.set_font("Helvetica", "B", 10)
        self.set_text_color(210, 140, 0)
        self.cell(0, 6, "Statut : PARTIEL", new_x="LMARGIN", new_y="NEXT")
        self.ln(2)

    def status_missing(self):
        self.set_font("Helvetica", "B", 10)
        self.set_text_color(200, 30, 30)
        self.cell(0, 6, "Statut : MANQUANT", new_x="LMARGIN", new_y="NEXT")
        self.ln(2)

pdf = PDF()
pdf.alias_nb_pages()
pdf.set_auto_page_break(auto=True, margin=20)
pdf.add_page()

# Titre principal
pdf.set_font("Helvetica", "B", 22)
pdf.set_text_color(30, 60, 120)
pdf.cell(0, 15, "Cahier des Charges", align="C", new_x="LMARGIN", new_y="NEXT")
pdf.set_font("Helvetica", "B", 16)
pdf.cell(0, 10, "Rapport d'avancement", align="C", new_x="LMARGIN", new_y="NEXT")
pdf.ln(3)
pdf.set_font("Helvetica", "", 11)
pdf.set_text_color(100, 100, 100)
pdf.cell(0, 7, "Projet : Gestion de la Licence - BTS 1ere annee", align="C", new_x="LMARGIN", new_y="NEXT")
pdf.cell(0, 7, "Date : 13 mai 2026", align="C", new_x="LMARGIN", new_y="NEXT")
pdf.ln(10)

# ============================================================
# TABLEAU RESUME
# ============================================================
pdf.section_title("Tableau resume")

data = [
    ("I", "Page de connexion", "IMPLIMENTE", "0 255 0"),
    ("II", "Calendrier (tableau semaine)", "PARTIEL", "210 140 0"),
    ("III", "Ajouter une intervention", "PARTIEL", "210 140 0"),
    ("IV", "Interventions (liste + filtres)", "PARTIEL", "210 140 0"),
    ("V", "Modifier / Supprimer intervention", "IMPLIMENTE", "0 180 0"),
    ("VI", "Corps enseignant", "PARTIEL", "210 140 0"),
    ("VII", "Fiche enseignant", "PARTIEL", "210 140 0"),
    ("VIII", "Modules (liste)", "PARTIEL", "210 140 0"),
    ("IX", "Module : ajout / modification", "MANQUANT", "200 30 30"),
    ("X", "Module : suppression", "MANQUANT", "200 30 30"),
    ("XI", "Types d'intervention (liste)", "IMPLIMENTE", "0 180 0"),
    ("XII", "Ajouter / modifier type", "IMPLIMENTE", "0 180 0"),
    ("XIII", "Type d'intervention : suppression", "MANQUANT", "200 30 30"),
]

col_w = [12, 90, 35, 53]
pdf.set_font("Helvetica", "B", 9)
pdf.set_fill_color(30, 60, 120)
pdf.set_text_color(255, 255, 255)
pdf.cell(col_w[0], 8, "N.", border=1, fill=True, align="C")
pdf.cell(col_w[1], 8, "Fonctionnalite", border=1, fill=True, align="C")
pdf.cell(col_w[2], 8, "Statut", border=1, fill=True, align="C")
pdf.cell(col_w[3], 8, "Priorite", border=1, fill=True, align="C")
pdf.ln()

priorities = {
    "I": "-",
    "II": "Basse",
    "III": "Haute",
    "IV": "Haute",
    "V": "-",
    "VI": "Moyenne",
    "VII": "Moyenne",
    "VIII": "Basse",
    "IX": "Haute",
    "X": "Haute",
    "XI": "-",
    "XII": "-",
    "XIII": "Moyenne",
}

for i, (num, name, status, color) in enumerate(data):
    pdf.set_font("Helvetica", "", 9)
    pdf.set_text_color(40, 40, 40)
    fill = i % 2 == 0
    if fill:
        pdf.set_fill_color(240, 245, 255)
    else:
        pdf.set_fill_color(255, 255, 255)
    pdf.cell(col_w[0], 7, num, border=1, fill=True, align="C")
    pdf.cell(col_w[1], 7, name, border=1, fill=True)
    r, g, b = map(int, color.split())
    pdf.set_text_color(r, g, b)
    pdf.set_font("Helvetica", "B", 9)
    pdf.cell(col_w[2], 7, status, border=1, fill=True, align="C")
    pdf.set_text_color(40, 40, 40)
    pdf.set_font("Helvetica", "", 9)
    pdf.cell(col_w[3], 7, priorities[num], border=1, fill=True, align="C")
    pdf.ln()

pdf.ln(8)

# ============================================================
# DETAIL PAR FONCTIONNALITE
# ============================================================
pdf.section_title("Detail par fonctionnalite")

# --- I ---
pdf.sub_title("I. Page de connexion")
pdf.status_ok()
pdf.sub_title("Ce qui est demande :")
pdf.body_text("Un formulaire avec email + mot de passe, verification des identifiants, message d'erreur si invalide.")
pdf.sub_title("Ce qui est fait :")
pdf.check("Formulaire avec email et mot de passe")
pdf.check("Verification avec password_verify() (mot de passe hash)")
pdf.check("Message d'erreur generique si identifiants incorrects")
pdf.check("Redirection apres connexion")
pdf.sub_title("Ce qui manque :")
pdf.body_text("Rien, la fonctionnalite est complete.")
pdf.ln(4)

# --- II ---
pdf.sub_title("II. Calendrier (tableau de la semaine)")
pdf.status_partial()
pdf.sub_title("Ce qui est demande :")
pdf.body_text("Afficher uniquement les interventions de la semaine actuelle dans un tableau. Colonnes : date (debut + fin), titre, module, type, intervenants, icone visio, bouton pour acceder a la fiche. Un bouton \"Ajouter une intervention\" en haut a droite.")
pdf.sub_title("Ce qui est fait :")
pdf.check("Toutes les colonnes sont presentes dans le tableau")
pdf.check("Bouton \"Ajouter une intervention\" qui ouvre la modale")
pdf.check("Lien \"Acceder a la fiche\" qui ouvre la modale en mode modification")
pdf.check("Icones visio (camera / camera barree)")
pdf.sub_title("Ce qui manque :")
pdf.cross("Le tableau affiche TOUTES les interventions avec pagination, au lieu de seulement celles de la semaine en cours.")
pdf.body_text("Il faudrait filtrer les interventions entre le lundi et le dimanche de la semaine actuelle via la requete SQL.")
pdf.ln(4)

# --- III ---
pdf.sub_title("III. Ajouter une intervention")
pdf.status_partial()
pdf.sub_title("Ce qui est demande :")
pdf.body_text("Une modale avec les champs : date de debut, date de fin, titre, module (selecteur), type d'intervention (selecteur), intervenants (cases a cocher multiples), visio (switch).")
pdf.body_text("4 validations obligatoires :\n1. La date de fin doit etre superieure a la date de debut\n2. Le titre ne doit pas depasser 255 caracteres\n3. L'intervention ne doit pas depasser 4 heures\n4. Les intervenants coches doivent obligatoirement intervenir sur le module selectionne")
pdf.sub_title("Ce qui est fait :")
pdf.check("Tous les champs du formulaire sont presents")
pdf.check("Verification que les champs obligatoires ne sont pas vides")
pdf.check("Verification qu'au moins un intervenant est selectionne")
pdf.check("L'intervention s'enregistre bien en base de donnees")
pdf.sub_title("Ce qui manque :")
pdf.cross("Validation date fin > date debut : si quelqu'un met une date de fin avant la date de debut, l'intervention est quand meme enregistree.")
pdf.cross("Validation titre <= 255 caracteres : aucun controle sur la longueur du titre.")
pdf.cross("Validation duree <= 4h : on peut creer une intervention de 10h.")
pdf.cross("Intervenants filtres par module : actuellement la modale affiche TOUS les intervenants de la base, sans filtre. Le CDC demande que seuls les intervenants qui enseignent dans le module selectionne apparaissent.")
pdf.ln(4)

# --- IV ---
pdf.sub_title("IV. Interventions (liste + filtres)")
pdf.status_partial()
pdf.sub_title("Ce qui est demande :")
pdf.body_text("Lister les interventions de la plus recente a la plus ancienne. 10 interventions par page avec pagination. 3 filtres fonctionnels : date de debut, date de fin, module. Colonnes : date, titre, module, type, intervenants, visio, bouton modifier.")
pdf.sub_title("Ce qui est fait :")
pdf.check("Tableau avec toutes les colonnes demandees")
pdf.check("Pagination a 10 par page")
pdf.check("3 champs de filtre visibles (date debut, date fin, module)")
pdf.sub_title("Ce qui manque :")
pdf.cross("Les filtres ne fonctionnent pas : les 3 champs sont bien affiches en HTML, mais le formulaire envoie les donnees en POST sans que le PHP ne les utilise. Si on tape une date et clique \"Filtrer\", la page se recharge mais la liste ne change pas.")
pdf.cross("Le tri par date decroissante n'est pas garanti (depend de la requete calendarData qui trie par id DESC, pas par date).")
pdf.ln(4)

# --- V ---
pdf.sub_title("V. Modifier / Supprimer une intervention")
pdf.status_ok()
pdf.sub_title("Ce qui est demande :")
pdf.body_text("Meme modale que l'ajout, pre-remplie avec les donnees existantes. Un bouton \"Supprimer\" en plus.")
pdf.sub_title("Ce qui est fait :")
pdf.check("La modale s'ouvre en mode modification avec les donnees pre-remplies")
pdf.check("Bouton \"Supprimer\" fonctionnel")
pdf.check("Bouton \"Mettre a jour\" fonctionnel")
pdf.check("Redirection apres suppression")
pdf.sub_title("Ce qui manque :")
pdf.body_text("Memes 4 validations que pour l'ajout (date fin > debut, titre 255 car., duree <= 4h, intervenants par module).")
pdf.ln(4)

# --- VI ---
pdf.sub_title("VI. Corps enseignant")
pdf.status_partial()
pdf.sub_title("Ce qui est demande :")
pdf.body_text("Lister les enseignants tries par nom de famille croissant (A -> Z). 10 par page avec pagination. 3 filtres : nom, prenom, email. Colonnes : nom, prenom, modules enseignes (noms separes par des virgules), nombre d'heures (cumul total des interventions), bouton consulter. Bouton \"Ajouter un enseignant\".")
pdf.sub_title("Ce qui est fait :")
pdf.check("Tableau avec nom, prenom, filtres (nom, prenom, email), pagination")
pdf.check("Bouton \"Ajouter un enseignant\" avec modale")
pdf.check("Bouton consulter (lien vers fiche enseignant)")
pdf.sub_title("Ce qui manque :")
pdf.cross("Colonne \"Modules enseignes\" : le tableau n'affiche pas les modules que chaque enseignant enseigne. Il faudrait une colonne avec par exemple \"Developpement Web, Bases de donnees\" (separes par des virgules). Cela necessite une requete SQL avec un GROUP_CONCAT ou une jointure.")
pdf.cross("Colonne \"Nombre d'heures\" : le tableau n'affiche pas le cumul des heures d'intervention de chaque enseignant. Il faudrait calculer la somme des durees de ses interventions.")
pdf.ln(4)

# --- VII ---
pdf.sub_title("VII. Fiche enseignant")
pdf.status_partial()
pdf.sub_title("Ce qui est demande :")
pdf.body_text("Commun aux 2 onglets : recapitulatif des modules enseignes avec nombre d'heures associe et heures restantes par module.")
pdf.body_text("Onglet Informations generales : formulaire avec nom, prenom, email, modules enseignes (selecteur multiple). Validations : nom/prenom non vides, email valide, modules existent en BDD.")
pdf.body_text("Onglet Interventions : liste des interventions de l'enseignant (plus recente d'abord), 10 par page avec pagination.")
pdf.sub_title("Ce qui est fait :")
pdf.check("2 onglets (informations + interventions)")
pdf.check("Formulaire nom, prenom, email avec validations (non vide + email valide)")
pdf.check("Tableau des interventions de l'enseignant avec filtres (dates, module)")
pdf.check("Affichage des modules enseignes avec heures")
pdf.sub_title("Ce qui manque :")
pdf.cross("Heures restantes par module : le CDC demande d'afficher pour chaque module \"X heures effectuees / Y heures prevues - Z heures restantes\". Actuellement on n'affiche que le nom du module et le nombre d'heures.")
pdf.cross("Modules enseignes = champ texte libre au lieu d'un selecteur multiple (balise <select multiple> avec les modules de la BDD). Actuellement c'est un <input type=\"text\"> qui ne fait que repeter le premier module.")
pdf.cross("Pagination dans l'onglet Interventions : toutes les interventions s'affichent sur une seule page, sans limite de 10.")
pdf.ln(4)

# --- VIII ---
pdf.sub_title("VIII. Modules (liste)")
pdf.status_partial()
pdf.sub_title("Ce qui est demande :")
pdf.body_text("Afficher les modules avec leur nom, nombre d'heures et module parent (s'il y en a un). Un bouton pour acceder a l'ajout d'un module.")
pdf.sub_title("Ce qui est fait :")
pdf.check("Affichage en arborescence avec nom et heures")
pdf.check("Bouton \"Ajouter un module\" qui ouvre une modale (fonction ajouterModule corrigee)")
pdf.sub_title("Ce qui manque :")
pdf.cross("Module parent : on ne voit pas quel module est le parent d'un autre (l'information existe en BDD via parent_id mais n'est pas affichee clairement).")
pdf.ln(4)

# --- IX ---
pdf.sub_title("IX. Module : ajout / modification")
pdf.status_missing()
pdf.sub_title("Ce qui est demande :")
pdf.body_text("Un formulaire avec : Code (obligatoire, unique), Nom (obligatoire, unique), Nombre d'heures (entier, facultatif), Parent (selecteur de module, facultatif), Description (textarea, obligatoire), Projet fil rouge (switch, facultatif, inactif par defaut).")
pdf.body_text("Validations : code/nom/description requis, heures doit etre un entier, parent doit exister en BDD, code et nom doivent etre uniques.")
pdf.body_text("3 boutons : \"Retour a la liste\", \"Supprimer\" (uniquement en modification), \"Enregistrer\".")
pdf.body_text("Mode ajout ET mode modification.")
pdf.sub_title("Ce qui est fait :")
pdf.cross("Le fichier module-fiche.php existe mais est entierement casse : il appelle insertTypeIntervention() au lieu d'une fonction pour les modules, les champs ne correspondent pas au CDC, aucun mode modification, aucune validation.")
pdf.cross("La modale d'ajout dans Modules.php a un formulaire basique (code, nom, heures, description) mais sans parent, sans fil rouge, sans validations d'unicite.")
pdf.body_text("Il faut tout refaire pour cette page.")
pdf.ln(4)

# --- X ---
pdf.sub_title("X. Module : suppression")
pdf.status_missing()
pdf.sub_title("Ce qui est demande :")
pdf.body_text("Une modale de confirmation avec un bouton rouge \"Confirmer\". Avant de supprimer, verifier qu'aucune intervention n'est liee a ce module.")
pdf.sub_title("Ce qui est fait :")
pdf.cross("Rien. Aucune modale, aucune verification, aucune fonction de suppression de module.")
pdf.ln(4)

# --- XI ---
pdf.sub_title("XI. Types d'intervention (liste)")
pdf.status_ok()
pdf.sub_title("Ce qui est demande :")
pdf.body_text("Lister les types par ordre alphabetique, 10 par page, pagination, filtre par nom, colonnes nom / descriptif / couleur / bouton modifier.")
pdf.sub_title("Ce qui est fait :")
pdf.check("Tout est present et fonctionnel.")
pdf.ln(4)

# --- XII ---
pdf.sub_title("XII. Ajouter / modifier un type d'intervention")
pdf.status_ok()
pdf.sub_title("Ce qui est demande :")
pdf.body_text("Formulaire avec nom, code couleur, description (tous obligatoires). Mode ajout et modification. Boutons retour, supprimer (modification uniquement), enregistrer.")
pdf.sub_title("Ce qui est fait :")
pdf.check("Tout est present et fonctionnel.")
pdf.ln(4)

# --- XIII ---
pdf.sub_title("XIII. Type d'intervention : suppression")
pdf.status_missing()
pdf.sub_title("Ce qui est demande :")
pdf.body_text("Une modale de confirmation avec un bouton rouge \"Confirmer\". Avant de supprimer, verifier qu'aucune intervention n'est liee a ce type.")
pdf.sub_title("Ce qui est fait :")
pdf.cross("Actuellement le bouton \"Supprimer\" supprime directement sans confirmation. Il n'y a pas de modale \"Etes-vous sur ?\" et pas de verification des interventions liees. Si des interventions utilisent ce type, la suppression echoue silencieusement avec juste un message d'erreur.")
pdf.ln(8)

output_path = "/Applications/XAMPP/xamppfiles/htdocs/projetFinal/projetFinal/DocumentationTechnique/Rapport_CDC_Gestion_Licence.pdf"
pdf.output(output_path)
print(f"PDF genere : {output_path}")
