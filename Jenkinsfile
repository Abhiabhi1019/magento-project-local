pipeline {
    agent any

    stages {

        stage('Checkout Code') {
            steps {
                git branch: 'main', url: 'https://github.com/Abhiabhi1019/magento-project-local.git'
            }
        }

        stage('Verify Workspace') {
            steps {
                sh '''
                echo Workspace
                pwd
                ls -la
                '''
            }
        }

        stage('Check Docker') {
            steps {
                sh '''
                docker --version
                docker-compose --version
                '''
            }
        }

        stage('Stop Old Containers') {
            steps {
                sh 'docker-compose down || true'
            }
        }

        stage('Build Containers') {
            steps {
                sh 'docker-compose build'
            }
        }

        stage('Start Containers') {
            steps {
                sh 'docker-compose up -d'
            }
        }

        stage('Verify Containers') {
            steps {
                sh 'docker ps'
            }
        }
    }
}
