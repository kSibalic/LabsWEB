const express = require('express');
const router = express.Router();
const Project = require('../models/project');

// List
router.get('/', async (req, res, next) => {
  try {
    const projects = await Project.find().sort({ createdAt: -1 });
    res.render('projects/index', { projects });
  } catch (err) {
    next(err);
  }
});

// New
router.get('/new', (req, res) => {
  res.render('projects/new', { project: {} });
});

// Create
router.post('/', async (req, res, next) => {
  try {
    const { title, description, price, completedTasks, startDate, endDate } = req.body;
    const project = new Project({
      title,
      description,
      price: price ? Number(price) : undefined,
      completedTasks: completedTasks ? Number(completedTasks) : 0,
      startDate: startDate || undefined,
      endDate: endDate || undefined
    });
    await project.save();
    res.redirect(`/projects/${project._id}`);
  } catch (err) {
    next(err);
  }
});

// Show
router.get('/:id', async (req, res, next) => {
  try {
    const project = await Project.findById(req.params.id);
    if (!project) return res.status(404).send('Projekt nije pronađen');
    res.render('projects/show', { project });
  } catch (err) {
    next(err);
  }
});

// Edit
router.get('/:id/edit', async (req, res, next) => {
  try {
    const project = await Project.findById(req.params.id);
    if (!project) return res.status(404).send('Projekt nije pronađen');
    res.render('projects/edit', { project });
  } catch (err) {
    next(err);
  }
});

// Update
router.put('/:id', async (req, res, next) => {
  try {
    const { title, description, price, completedTasks, startDate, endDate } = req.body;
    const update = {
      title,
      description,
      price: price ? Number(price) : undefined,
      completedTasks: completedTasks ? Number(completedTasks) : 0,
      startDate: startDate || undefined,
      endDate: endDate || undefined
    };
    await Project.findByIdAndUpdate(req.params.id, update);
    res.redirect(`/projects/${req.params.id}`);
  } catch (err) {
    next(err);
  }
});

// Delete
router.delete('/:id', async (req, res, next) => {
  try {
    await Project.findByIdAndDelete(req.params.id);
    res.redirect('/projects');
  } catch (err) {
    next(err);
  }
});

/* Team members */
// Add
router.post('/:id/team', async (req, res, next) => {
  try {
    const { name, role, email } = req.body;
    const project = await Project.findById(req.params.id);
    if (!project) return res.status(404).send('Projekt nije pronađen');
    project.team.push({ name, role, email });
    await project.save();
    res.redirect(`/projects/${req.params.id}`);
  } catch (err) {
    next(err);
  }
});

// Delete
router.delete('/:id/team/:index', async (req, res, next) => {
  try {
    const idx = Number(req.params.index);
    const project = await Project.findById(req.params.id);
    if (!project) return res.status(404).send('Projekt nije pronađen');
    if (isNaN(idx) || idx < 0 || idx >= project.team.length) return res.status(400).send('Neispravan index');
    project.team.splice(idx, 1);
    await project.save();
    res.redirect(`/projects/${req.params.id}`);
  } catch (err) {
    next(err);
  }
});

module.exports = router;