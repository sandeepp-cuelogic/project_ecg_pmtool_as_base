require 'rails_helper'


RSpec.describe User, type: :model do
    describe 'creation and validation' do
    it 'is valid user name' do
      user = FactoryGirl.build(:user)
      expect(user.valid?).to eq true
      #expect(user.errors.has_key?(:name)).to eq true
    end

    it 'is invalid user name' do
      user = FactoryGirl.build(:invalid_user)
      expect(user.valid?).not_to eq true
      #expect(user.errors.has_key?(:name)).to eq true
    end

    it 'is valid user email' do
      user = FactoryGirl.build(:user)
      expect(user.valid?).to eq false
      #expect(user.errors.has_key?(:name)).to eq true
    end

    it 'is invalid user email' do
      user = FactoryGirl.build(:invalid_user)
      expect(user.valid?).to eq false
      #expect(user.errors.has_key?(:name)).to eq true
    end
  end
end
