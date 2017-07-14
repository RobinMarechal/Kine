<?php


use Ramsey\Uuid\FeatureSet;

Class Feature
{
	private $name;
	private $done = false;


	function __construct ($name, $done = false)
	{
		$this->name = $name;
		$this->done = $done;
	}


	public function getName ()
	{
		return $this->name;
	}


	public function isDone ()
	{
		return $this->done;
	}


}



Class FeatureSection
{
	private $title;
	private $features = [];


	function __construct ($title)
	{
		$this->title = $title;
	}


	public function add ($feature)
	{
		$this->features[] = $feature;
	}


	public function getFeatures ()
	{
		return $this->features;
	}


	public function getTitle ()
	{
		return $this->title;
	}


}



$featureSections = [];

$user = new FeatureSection('Utilisateur');
$user->add(new Feature('Connexion classique', true));
$user->add(new Feature('Connexion par Facebook', true));
$user->add(new Feature('Voir ses notifications'));

$featureSections[] = $user;

$appearance = new FeatureSection('Apparence générale');
$appearance->add(new Feature('Menus', true));
$appearance->add(new Feature('Contenu principal', true));
$appearance->add(new Feature('Rubriques latérales', true));
$appearance->add(new Feature('Pied de page', true));

$featureSections[] = $appearance;

$footer = new FeatureSection('Pied de page');
$footer->add(new Feature('Horaires', true));
$footer->add(new Feature('Contacts (tel, mail, réseaux sociaux)', true));
$footer->add(new Feature('Adresse du cabinet', true));
$footer->add(new Feature('Numéro de téléphone du cabinet', true));

$featureSections[] = $footer;

$accueil = new FeatureSection("Page d'accueil");
$accueil->add(new Feature("Pas de rubriques latérales", true));
$accueil->add(new Feature("Récap des derniers posts"));

$featureSections[] = $accueil;

$quiSommesNous = new FeatureSection("Qui sommes nous");
$quiSommesNous->add(new Feature("Une page pour présenter tout le monde"));

$featureSections[] = $quiSommesNous;

$nosCompetences = new FeatureSection("Nos compétences");
$nosCompetences->add(new Feature("Plusieurs rubriques"));

$featureSections[] = $nosCompetences;

$galerie = new FeatureSection("Médias");
$galerie->add(new Feature("Galerie générale"));
$galerie->add(new Feature("Galerie par post"));

$featureSections[] = $galerie;

$articles = new FeatureSection("Articles");
$articles->add(new Feature("Publier un article"));
$articles->add(new Feature("Modifier un article"));
$articles->add(new Feature("Supprimer un article"));
$articles->add(new Feature("Gérer les médias"));
$articles->add(new Feature("Gérer les tags"));

$featureSections[] = $articles;

$news = new FeatureSection("News");
$news->add(new Feature("Publier un news"));
$news->add(new Feature("Modifier un news"));
$news->add(new Feature("Supprimer un news"));

$featureSections[] = $news;

$events = new FeatureSection("Événements");
$events->add(new Feature("Créer un événement"));
$events->add(new Feature("Modifier un événement"));
$events->add(new Feature("Supprimer un événement"));
$events->add(new Feature("Avertir sur le site"));

$featureSections[] = $events;

$cours = new FeatureSection("Cours");
$cours->add(new Feature("Créer un cours"));
$cours->add(new Feature("Modifier un cours"));
$cours->add(new Feature("Supprimer un cours"));
$cours->add(new Feature("Ajouter un docteur à un cours"));
$cours->add(new Feature("Supprimer un docteur d'un cours"));
$cours->add(new Feature("Ajouter un participant à un cours"));
$cours->add(new Feature("Supprimer un participant d'un cours"));

$featureSections[] = $cours;

$contacts = new FeatureSection("Contacts");
$contacts->add(new Feature("Ajouter un contact (tel/mail/réseau social)"));
$contacts->add(new Feature("Supprimer un contact"));
$contacts->add(new Feature("Modifier un contact"));

$featureSections[] = $contacts;

$admin = new FeatureSection("Administration");
$admin->add(new Feature("Liste des membres inscrits"));
$admin->add(new Feature("Ajouter un droit à un membre inscrit"));
$admin->add(new Feature("Retirer un droit à un membre inscrit"));
$admin->add(new Feature("Vue d'ensemble"));

$featureSections[] = $admin;

$autres = new FeatureSection("Autres");
$autres->add(new Feature("Modifier les textes"));
$autres->add(new Feature("Recherche"));

$featureSections[] = $autres;

$fb = new FeatureSection("Facebook");
$fb->add(new Feature("Lier les publications facebook au site"));

$featureSections[] = $fb;

$yt = new FeatureSection("Youtube");
$yt->add(new Feature("Lier la chaine youtube au site"));

$featureSections[] = $yt;

?>

@extends('layouts.app')

@section('content')

	<h1>Avancement</h1>
	<div id="features">
		@forelse($featureSections as $section)
			<section style="margin-left:20px;">
				<h3 style="margin-bottom:20px;">{{$section->getTitle()}}</h3>
				@forelse($section->getFeatures() as $f)
					<div class="form-group" style="margin:5px 0 5px 20px">
						<label><input disabled type="checkbox" @if($f->isDone()) checked @endif> {{$f->getName()}}</label>
					</div>
				@empty
					<p>-</p>
				@endforelse
			</section>
			<hr>
		@empty
			<p>Rien.</p>
		@endforelse
	</div>




@endsection