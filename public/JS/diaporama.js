
// Classe pour ajouter des slides de texte ou d'image

class Slide {

	constructor(element, parent, id, classe, image, alt, largeur, hauteur){

		this.element = element;
		this.parent = parent;
		this.id = id;
		this.image = image;
		this.alt = alt;
		this.largeur = largeur;
		this.hauteur = hauteur;
		this.classe = classe;
	}

	ajouterSlide(){
		$(this.element).appendTo(this.parent);
		$(this.element).attr("id", this.id).attr("class", this.classe).attr("alt", this.alt).attr("src", this.image);
		$(this.element).css("width", this.largeur).css("height", this.hauteur);
	}
}

	

	
// Classe pour ajouter un Diaporama

class Diaporama {

	constructor(i, modele, imax, imin, play, pause, actionLumiere, gauche, droit){

		this.i = i;
		this.modele = modele;
		this.imax = imax;
		this.imin = imin;
		this.play = play;
		this.pause = pause;
		this.actionLumiere = actionLumiere;
		this.gauche = gauche;
		this.droit = droit;
	}

	ajouterDiaporama(){

		$(this.play).hide();
		$(this.pause).show();
			

		$(this.play).click(function(){
			this.boutonPlay();
		}.bind(this));

		$(this.pause).click(function(){
			this.boutonPause();
		}.bind(this));

		$(this.gauche).click(function(){
			this.boutonGauche();
		}.bind(this));

		$(this.droit).click(function(){
			this.boutonDroit();
		}.bind(this));

		$(window).keydown(function(e){ 
			if (e.keyCode === 37){ // Flèche du clavier GAUCHE donc même fonctionnement que le clic sur le chevron gauche
				this.boutonGauche();
			}

			if (e.keyCode === 39){ // Flèche du clavier DROIT donc même fonctionnement que le clic sur le chevron droit
				this.boutonDroit();
			}

			if (e.keyCode === 32){ // BARRE D'ESPACE qui met en pause ou en play le diaporama 

				$(this.play).toggle(); // On inverse l'état de play
				$(this.pause).toggle(); // On inverse l'état de pause
				this.actionLumiere = !this.actionLumiere; // On inverse la valeur boolean de actionLumière

				if (this.actionLumiere === true) { // Si actionLumière vaut TRUE alors on stop le diaporama
					this.stopInterval();
				}
				else { // Sinon on laisse le diaporama s'enchainer normalement
					this.playInterval(this.affichageHoraire, 5000);
				}
			}
		}.bind(this));
	}

	affichageHoraire() {
	     
		let precedent;
		let actuel;


		this.i++; // On incrémente i à chaque appel de la fonction

		if (this.i === this.imax + 1)
		{
			this.i = 1;
		}// On réinitialise le i à 1 quand il atteint 9

		if (this.i === 1) {
		    precedent = this.modele + this.imax; // Gestion de l'exception pour boucler le diaporama à l'infini

		}
		else {
		    precedent = this.modele + (this.i - 1); // On utilise la valeur de i - 1 pour déterminer la diapo précédente

		}

		actuel = this.modele + this.i; // On utilise donc la valeur de i pour déterminer la diapo actuel qui s'affiche

		$(precedent).fadeOut(1500);
		$(actuel).fadeIn(1500);

    }

    affichageContreHoraire() {
	    
		let actuelBack;
		let precedentBack;

		this.i--;

		if (this.i === 0) this.i = this.imax; // On réinitialise i à 8 quand il atteint 0

		if (this.i === this.imax) {
		    precedentBack = this.modele + this.imin; // Gestion de l'exception pour boucler le diaporama à l'infini
		}

		else {
		    precedentBack = this.modele + (this.i + 1); // On utilise la valeur de i + 1 pour déterminer la diapo précédente
		}

		actuelBack = this.modele + this.i; // On utilise donc la valeur de i pour déterminer la diapo actuel qui s'affiche

		$(actuelBack).fadeIn(1500);
		$(precedentBack).fadeOut(1500);
	}

    playInterval(methode, timer){

    	this.interval = setInterval(methode.bind(this), timer);
    }

    stopInterval(){

    	clearInterval(this.interval);
    }

    boutonPlay(){
    	$(this.play).toggle(); // On inverse l'état de play lors du clic
		$(this.pause).toggle(); // On inverse l'état de pause lors du clic
		this.actionLumiere = false;
		if (this.actionLumiere === false){
			this.playInterval(this.affichageHoraire, 5000);
		}
    }

    boutonPause(){
    	$(this.play).toggle(); // On inverse l'état de play lors du clic
		$(this.pause).toggle(); // On inverse l'état de pause lors du clic
		this.actionLumiere = true;
		if (this.actionLumiere === true){
			this.stopInterval();
		}
    }

    boutonGauche(){

    	setTimeout(function(){ // Permet de n'activer la fonction qu'une fois à chaque clic

			this.stopInterval(); // On stop le diaporama
			this.affichageContreHoraire(); // On appel la fonction affichageContreHoraire

			if (this.actionLumiere === false) { // Si la valeur est False (donc diaporama en lecture / Play) on relance le diaporama normalement 
				this.playInterval(this.affichageHoraire, 5000);	
			}
		}.bind(this));
    }

    boutonDroit(){

    	setTimeout(function(){ // Permet de n'activer la fonction qu'une fois à chaque clic

			this.stopInterval(); // On stop le diaporama
			this.affichageHoraire(); // On appel la fonction affichageHoraire
			 
			if (this.actionLumiere === false) { // Si la valeur est False (donc diaporama en lecture / Play) on relance le diaporama normalement 
				this.playInterval(this.affichageHoraire, 5000);
			}
		}.bind(this));
    }
}
	

	




