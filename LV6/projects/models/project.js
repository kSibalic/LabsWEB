const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const TeamMemberSchema = new Schema({
  name: { type: String, required: true },
  role: { type: String },
  email: { type: String }
}, { _id: false });

const ProjectSchema = new Schema({
  title: { type: String, required: true },
  description: { type: String },
  price: { type: Number, min: 0 },
  completedTasks: { type: Number, default: 0, min: 0 },
  startDate: { type: Date },
  endDate: { type: Date },
  team: { type: [TeamMemberSchema], default: [] }
}, { timestamps: true });

module.exports = mongoose.model('Project', ProjectSchema);